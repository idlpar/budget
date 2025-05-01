<?php

namespace App\Http\Controllers;

use App\Imports\EstimatedBudgetImport;
use App\Imports\RevisedBudgetImport;
use App\Models\Budget;
use App\Models\AccountHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $query = Budget::with(['accountHead', 'user']);

        if ($request->filled('account_search')) {
            $search = $request->input('account_search');
            $query->whereHas('accountHead', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('serial')) {
            $query->where('serial', 'like', '%' . $request->input('serial') . '%');
        }

        if ($request->filled('account_head')) {
            $query->whereHas('accountHead', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('account_head') . '%');
            });
        }

        if ($request->filled('amount')) {
            $query->where('amount', $request->input('amount'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('uploaded_by')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('uploaded_by') . '%');
            });
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->input('created_at'));
        }

        $perPage = $request->input('per_page', 10);
        if ($perPage === 'all') {
            $budgets = $query->get();
        } else {
            $budgets = $query->paginate($perPage);
        }

        $totalsByAccountType = Budget::selectRaw('account_heads.type as account_type, SUM(budgets.amount) as total_amount')
            ->join('account_heads', 'budgets.account_head_id', '=', 'account_heads.id')
            ->whereIn('budgets.id', $perPage === 'all' ? $budgets->pluck('id') : $budgets->pluck('id'))
            ->groupBy('account_heads.type')
            ->pluck('total_amount', 'account_type')
            ->toArray();

        return view('budgets.index', compact('budgets', 'totalsByAccountType'));
    }

    public function show(Budget $budget)
    {
        return view('budgets.show', compact('budget'));
    }

    public function edit(Budget $budget)
    {
        $accountHeads = AccountHead::all();
        return view('budgets.edit', compact('budget', 'accountHeads'));
    }

    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'serial' => 'required|string|unique:budgets,serial,' . $budget->id,
            'account_head_id' => 'required|exists:account_heads,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:estimated,revised',
            'financial_year' => 'required|string|regex:/^[0-9]{4}-[0-9]{4}$/',
        ]);

        $budget->update($validated);

        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
    }

    public function uploadForm()
    {
        $usedAccountHeadIds = Budget::pluck('account_head_id')->toArray();
        $accountHeads = AccountHead::whereNotIn('id', $usedAccountHeadIds)
            ->orderBy('name', 'asc') // You can replace 'name' with 'id' or another field
            ->get();

        $latestBudget = Budget::orderBy('id', 'desc')->first();
        $lastSerial = $latestBudget ? $latestBudget->serial : null;

        $financialYears = Budget::select('financial_year')
            ->distinct()
            ->pluck('financial_year')
            ->filter()
            ->sort()
            ->values();

        return view('budgets.upload', compact('accountHeads', 'lastSerial', 'financialYears'));
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'serial' => 'required|string|unique:budgets,serial',
            'account_head_id' => 'required|exists:account_heads,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:estimated,revised',
            'financial_year' => 'required_if:custom_financial_year,==,null|string|regex:/^[0-9]{4}-[0-9]{4}$/',
            'custom_financial_year' => 'required_if:financial_year,==,custom|string|regex:/^[0-9]{4}-[0-9]{4}$/',
        ]);

        // Use custom_financial_year if financial_year is "custom"
        $financialYear = $request->input('financial_year') === 'custom'
            ? $request->input('custom_financial_year')
            : $request->input('financial_year');

        Budget::create([
            'serial' => $validated['serial'],
            'account_head_id' => $validated['account_head_id'],
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'financial_year' => $financialYear,
            'user_id' => Auth::id(),
            'status' => 'active',
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget uploaded successfully.');
    }

    public function showImportForm()
    {
        return view('budgets.import');
    }

    public function importEstimated(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'financial_year' => 'required|string|regex:/^[0-9]{4}-[0-9]{4}$/',
        ]);

        try {
            Excel::import(
                new EstimatedBudgetImport(
                    $request->financial_year,
                    Auth::id()
                ),
                $request->file('file')
            );
            return redirect()->route('budgets.index')->with('success', 'Estimated budgets imported successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Error importing file: ' . $e->getMessage()]);
        }
    }

    public function importRevised(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'financial_year' => 'required|string|regex:/^[0-9]{4}-[0-9]{4}$/',
        ]);

        try {
            Excel::import(
                new RevisedBudgetImport($request->financial_year, Auth::id()),
                $request->file('file')
            );
            return redirect()->route('budgets.index')->with('success', 'Revised budgets imported successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Error importing file: ' . $e->getMessage()]);
        }
    }

    public function revise(Request $request, Budget $budget)
    {
        $request->validate([
            'revised_amount' => 'required|numeric|min:0',
        ]);

        Budget::updateOrCreate(
            [
                'account_head_id' => $budget->account_head_id,
                'financial_year' => $budget->financial_year,
                'type' => 'revised',
            ],
            [
                'serial' => $budget->serial,
                'amount' => $request->revised_amount,
                'user_id' => $budget->user_id,
                'status' => 'active',
            ]
        );

        return redirect()->route('budgets.index')->with('success', 'Budget revised successfully.');
    }
}
