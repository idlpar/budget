<?php

namespace App\Http\Controllers;

use App\Models\AccountHead;
use App\Models\AccountHeadChange;
use App\Imports\AccountHeadsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AccountHeadController extends Controller
{
    public function index(Request $request)
    {
        $query = AccountHead::query();

        // Log the request parameters
        Log::debug('Filter parameters received', $request->only(['account_code', 'name', 'type', 'search']));

        // Apply filters
        if ($request->filled('account_code')) {
            $query->where('account_code', 'like', '%' . $request->input('account_code') . '%');
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Apply search
        if ($request->filled('search')) {
            $search = $request->input('search');
            // Remove hyphens from search term for account_code comparison
            $searchWithoutHyphens = str_replace('-', '', $search);
            $query->where(function ($q) use ($search, $searchWithoutHyphens) {
                $q->where('account_code', 'like', '%' . $searchWithoutHyphens . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        // Get the filtered account heads
        $accountHeads = $query->get();

        // Get distinct types for the filter dropdown
        $types = AccountHead::distinct('type')->pluck('type');

        // Get total count
        $totalHeads = $accountHeads->count();

        Log::info('Account Heads index accessed', [
            'user_id' => auth()->id(),
            'filters' => $request->only(['account_code', 'name', 'type', 'search']),
            'total_heads' => $totalHeads,
        ]);

        return view('accounts.index', compact('accountHeads', 'types', 'totalHeads'));
    }


    public function create()
    {
        Log::info('Account Head create form accessed', ['user_id' => auth()->id()]);
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_code' => ['required', 'string', 'max:255', Rule::unique('account_heads')],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            $accountHead = AccountHead::create([
                'account_code' => $validated['account_code'],
                'name' => $validated['name'],
                'type' => $validated['type'],
                'created_by' => auth()->id(),
                'updated_by' => null,
            ]);

            Log::info('Account Head created', ['account_head_id' => $account = $accountHead->id, 'created_by' => auth()->id()]);

            DB::commit();

            return redirect()->route('accounts.index')->with('success', 'Account Head created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Account Head creation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to create Account Head: ' . $e->getMessage());
        }
    }

    public function show(AccountHead $accountHead)
    {
        Log::info('Account Head show accessed', ['account_head_id' => $accountHead->id, 'accessed_by' => auth()->id()]);
        $accountHead->load('changes');
        return view('accounts.show', compact('accountHead'));
    }

    public function edit(AccountHead $accountHead)
    {
        Log::info('Account Head edit form accessed', ['account_head_id' => $accountHead->id, 'accessed_by' => auth()->id()]);
        return view('accounts.edit', compact('accountHead'));
    }

    public function update(Request $request, AccountHead $accountHead)
    {
        $validated = $request->validate([
            'account_code' => ['required', 'string', 'max:255', Rule::unique('account_heads')->ignore($accountHead->id)],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            $changes = [];
            foreach (['account_code', 'name', 'type'] as $field) {
                if ($accountHead->$field !== $validated[$field]) {
                    $changes[] = [
                        'account_head_id' => $accountHead->id,
                        'field_name' => $field,
                        'old_value' => $accountHead->$field,
                        'new_value' => $validated[$field],
                        'changed_by' => auth()->id(),
                    ];
                }
            }

            if (!empty($changes)) {
                AccountHeadChange::insert($changes);
            }

            $accountHead->update([
                'account_code' => $validated['account_code'],
                'name' => $validated['name'],
                'type' => $validated['type'],
                'updated_by' => auth()->id(),
            ]);

            Log::info('Account Head updated', [
                'account_head_id' => $accountHead->id,
                'changes' => $changes,
                'updated_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('accounts.index')->with('success', 'Account Head updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Account Head update failed', [
                'account_head_id' => $accountHead->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to update Account Head: ' . $e->getMessage());
        }
    }

    public function importForm()
    {
        $canImport = AccountHead::count() === 0;
        Log::info('Account Head import form accessed', ['user_id' => auth()->id()]);
        return view('accounts.import', compact('canImport'));
    }

    public function import(Request $request)
    {
        if (AccountHead::count() > 0) {
            return redirect()->route('accounts.index')->with('error', 'Import already performed. Cannot import again.');
        }

        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        try {
            DB::beginTransaction();
            Excel::import(new AccountHeadsImport, $request->file('file'));
            Log::info('Account Heads imported', ['user_id' => auth()->id()]);
            DB::commit();
            return redirect()->route('accounts.index')->with('success', 'Account Heads imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Account Heads import failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to import Account Heads: ' . $e->getMessage());
        }
    }
}
