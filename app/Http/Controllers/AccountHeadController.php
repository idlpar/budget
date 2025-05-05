<?php

namespace App\Http\Controllers;

use App\Models\AccountHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AccountHeadsImport;

class AccountHeadController extends Controller
{
    public function index(Request $request)
    {
        $types = ['Revenue', 'Expense', 'Asset', 'Equity', 'Liability'];
        $perPage = $request->input('per_page', 10);
        if ($perPage === 'all') {
            $perPage = AccountHead::count();
        }

        $query = AccountHead::query();

        if ($request->filled('account_code')) {
            $query->whereRaw('LOWER(account_code) LIKE ?', ['%' . strtolower($request->account_code) . '%']);
        }

        if ($request->filled('name')) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->name) . '%']);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw('LOWER(account_code) LIKE ?', ['%' . strtolower($request->search) . '%'])
                    ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->search) . '%']);
            });
        }

        $totalHeads = $query->count();
        $accountHeads = $query->with('creator')->paginate($perPage)->appends($request->except('page'));

        $accountHeads->getCollection()->transform(function ($accountHead) {
            if (strlen($accountHead->account_code) === 10) {
                $accountHead->formatted_account_code = substr($accountHead->account_code, 0, 2) . '-' .
                    substr($accountHead->account_code, 2, 3) . '-' .
                    substr($accountHead->account_code, 5, 5);
            } else {
                $accountHead->formatted_account_code = $accountHead->account_code;
            }
            return $accountHead;
        });

        Log::info('Account Heads index accessed', [
            'user_id' => auth()->id(),
            'filters' => $request->only(['account_code', 'name', 'type', 'search', 'per_page']),
            'total_heads' => $totalHeads,
        ]);

        return view('accounts.index', compact('accountHeads', 'totalHeads', 'types', 'perPage'));
    }

    public function create()
    {
        $types = ['Revenue', 'Expense', 'Asset', 'Equity', 'Liability'];
        Log::info('Account Head create form accessed', ['user_id' => auth()->id()]);
        return view('accounts.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'type' => strtolower($request->input('type')),
        ]);

        $validated = $request->validate([
            'account_code' => 'required|string|unique:account_heads,account_code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:revenue,expense,asset,liability,equity',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $accountHead = AccountHead::create([
                'account_code' => $validated['account_code'],
                'name' => $validated['name'],
                'type' => $validated['type'],
                'created_by' => auth()->id(),
            ]);

            Log::info('Account Head created', [
                'account_head_id' => $accountHead->id,
                'created_by' => auth()->id(),
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('accounts.index')->with('success', 'Account Head created successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error('Account Head creation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to create account head: ' . $e->getMessage());
        }
    }

    public function show(AccountHead $accountHead)
    {
        $accountHead->load(['creator', 'updater', 'changes.changer']);
        Log::info('Account Head viewed', [
            'account_head_id' => $accountHead->id,
            'accessed_by' => auth()->id(),
        ]);
        return view('accounts.show', compact('accountHead'));
    }

    public function edit(AccountHead $accountHead)
    {
        $types = ['Revenue', 'Expense', 'Asset', 'Equity', 'Liability'];
        Log::info('Account Head edit form accessed', [
            'account_head_id' => $accountHead->id,
            'accessed_by' => auth()->id(),
        ]);
        return view('accounts.edit', compact('accountHead', 'types'));
    }

    public function update(Request $request, AccountHead $accountHead)
    {
        $request->merge([
            'type' => strtolower($request->input('type')),
        ]);

        $validated = $request->validate([
            'account_code' => 'required|string|unique:account_heads,account_code,' . $accountHead->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:revenue,expense,asset,liability,equity',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $changes = [];
            if ($accountHead->account_code !== $validated['account_code']) {
                $changes[] = [
                    'field_name' => 'account_code',
                    'old_value' => $accountHead->account_code,
                    'new_value' => $validated['account_code'],
                    'changed_by' => auth()->id(),
                ];
            }
            if ($accountHead->name !== $validated['name']) {
                $changes[] = [
                    'field_name' => 'name',
                    'old_value' => $accountHead->name,
                    'new_value' => $validated['name'],
                    'changed_by' => auth()->id(),
                ];
            }
            if ($accountHead->type !== $validated['type']) {
                $changes[] = [
                    'field_name' => 'type',
                    'old_value' => $accountHead->type,
                    'new_value' => $validated['type'],
                    'changed_by' => auth()->id(),
                ];
            }

            $accountHead->update(array_merge($validated, ['updated_by' => auth()->id()]));

            foreach ($changes as $change) {
                $accountHead->changes()->create($change);
            }

            Log::info('Account Head updated', [
                'account_head_id' => $accountHead->id,
                'updated_by' => auth()->id(),
                'changes' => $changes,
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('accounts.index')->with('success', 'Account Head updated successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error('Account Head update failed', [
                'account_head_id' => $accountHead->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to update account head: ' . $e->getMessage());
        }
    }

    public function destroy(AccountHead $accountHead)
    {
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();
            $accountHead->delete();
            Log::info('Account Head deleted', [
                'account_head_id' => $accountHead->id,
                'deleted_by' => auth()->id(),
            ]);
            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('accounts.index')->with('success', 'Account Head deleted successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error('Account Head deletion failed', [
                'account_head_id' => $accountHead->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to delete account head: ' . $e->getMessage());
        }
    }

    public function importForm()
    {
        Log::info('Account Head import form accessed', ['user_id' => auth()->id()]);
        return view('accounts.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();
            Excel::import(new AccountHeadsImport, $request->file('file'));
            Log::info('Account Heads imported', ['user_id' => auth()->id()]);
            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('accounts.index')->with('success', 'Account Heads imported successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error('Account Heads import failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to import account heads: ' . $e->getMessage());
        }
    }

    public function getRemainingBudget(Request $request, $accountHeadId)
    {
        try {
            $financialYear = $request->input('financial_year', '2023-2024');

            $budget = Budget::where('account_head_id', $accountHeadId)
                ->where('financial_year', $financialYear)
                ->where('status', 'active')
                ->orderByRaw("CASE WHEN type = 'revised' THEN 1 WHEN type = 'estimated' THEN 2 ELSE 3 END")
                ->first();

            if (!$budget) {
                return response()->json(['error' => 'No active budget found for this account head and financial year'], 404);
            }

            $totalExpenses = Expense::whereHas('transactionEntries', function ($q) use ($accountHeadId) {
                $q->where('account_head_id', $accountHeadId);
            })
                ->where('status', 'approved')
                ->where('financial_year', $financialYear)
                ->sum('amount');

            $remainingBudget = $budget->amount - $totalExpenses;

            Log::info('Remaining budget calculated', [
                'account_head_id' => $accountHeadId,
                'financial_year' => $financialYear,
                'budget_amount' => $budget->amount,
                'total_expenses' => $totalExpenses,
                'remaining_budget' => $remainingBudget,
            ]);

            return response()->json(['remaining_budget' => $remainingBudget]);
        } catch (\Exception $e) {
            Log::error('Error calculating remaining budget', [
                'account_head_id' => $accountHeadId,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Unable to calculate remaining budget: ' . $e->getMessage()], 500);
        }
    }
}
