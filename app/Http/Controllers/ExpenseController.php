<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Budget;
use App\Models\AccountHead;
use App\Models\Transaction;
use App\Models\TransactionEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    public function index()
    {
        $query = Expense::query()->with(['accountHead', 'budget', 'department', 'section']);

        if (!auth()->user()->is_admin) {
            if (auth()->user()->division_id) {
                $query->whereHas('department', function ($q) {
                    $q->where('division_id', auth()->user()->division_id);
                });
            }
            if (auth()->user()->department_id) {
                $query->where('department_id', auth()->user()->department_id);
            }
            if (auth()->user()->section_id) {
                $query->where('section_id', auth()->user()->section_id);
            }
        }

        $expenses = $query->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $budgets = Budget::where('status', 'active')->get();
        $accountHeads = AccountHead::all();
        $divisions = \App\Models\Division::all();
        return view('expenses.create', compact('budgets', 'accountHeads', 'divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_heads' => 'required|array|min:1',
            'account_heads.*.account_head_id' => 'required|exists:account_heads,id',
            'account_heads.*.amount' => 'required|numeric|min:0.01',
            'budget_id' => 'required|exists:budgets,id',
            'department_id' => 'required|exists:departments,id',
            'section_id' => 'required|exists:sections,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Check budget limits for each account head
            $errors = [];
            foreach ($request->account_heads as $entry) {
                $accountHeadId = $entry['account_head_id'];
                $amount = $entry['amount'];

                $budget = Budget::where('account_head_id', $accountHeadId)
                    ->where('financial_year', Budget::findOrFail($request->budget_id)->financial_year)
                    ->where('status', 'active')
                    ->first();

                if (!$budget) {
                    $errors[] = "No active budget found for account head ID {$accountHeadId}.";
                    continue;
                }

                $totalExpenses = Expense::where('budget_id', $budget->id)
                    ->where('status', 'approved')
                    ->sum('amount');

                $budgetLimit = $budget->type === 'revised' ? $budget->amount : Budget::where('account_head_id', $accountHeadId)
                    ->where('type', 'revised')
                    ->where('financial_year', $budget->financial_year)
                    ->first()?->amount ?? $budget->amount;

                if ($totalExpenses + $amount > $budgetLimit) {
                    $accountHead = AccountHead::find($accountHeadId);
                    $errors[] = "Expense for {$accountHead->name} exceeds the {$budget->type} budget limit.";
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
                return redirect()->back()->withErrors(['account_heads' => $errors])->withInput();
            }

            // Create expense and transaction
            $expense = Expense::create([
                'budget_id' => $request->budget_id,
                'department_id' => $request->department_id,
                'section_id' => $request->section_id,
                'amount' => collect($request->account_heads)->sum('amount'),
                'transaction_date' => $request->transaction_date,
                'user_id' => auth()->id(),
                'status' => 'pending',
            ]);

            $transaction = Transaction::create([
                'section_id' => $request->section_id,
                'transaction_date' => $request->transaction_date,
                'description' => $request->description ?? 'Expense transaction',
                'created_by' => auth()->id(),
            ]);

            foreach ($request->account_heads as $entry) {
                TransactionEntry::create([
                    'transaction_id' => $transaction->id,
                    'account_head_id' => $entry['account_head_id'],
                    'debit' => $entry['amount'],
                    'expense_id' => $expense->id,
                ]);
            }

            Log::info('Expense recorded', [
                'expense_id' => $expense->id,
                'user_id' => auth()->id(),
                'account_heads' => $request->account_heads,
            ]);

            DB::commit();
            return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Expense creation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to record expense: ' . $e->getMessage());
        }
    }

    public function approve(Request $request, Expense $expense)
    {
        $expense->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        \App\Models\ExpenseApproval::create([
            'expense_id' => $expense->id,
            'approver_id' => auth()->id(),
            'level' => auth()->user()->role === 'division_head' ? 'division' : (auth()->user()->role === 'department_head' ? 'department' : 'section'),
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        Log::info('Expense approved', ['expense_id' => $expense->id, 'approved_by' => auth()->id()]);

        return redirect()->route('expenses.index')->with('success', 'Expense approved.');
    }

    public function reject(Request $request, Expense $expense)
    {
        $expense->update(['status' => 'rejected']);

        \App\Models\ExpenseApproval::create([
            'expense_id' => $expense->id,
            'approver_id' => auth()->id(),
            'level' => auth()->user()->role === 'division_head' ? 'division' : (auth()->user()->role === 'department_head' ? 'department' : 'section'),
            'status' => 'rejected',
        ]);

        Log::info('Expense rejected', ['expense_id' => $expense->id, 'rejected_by' => auth()->id()]);

        return redirect()->route('expenses.index')->with('success', 'Expense rejected.');
    }
}
