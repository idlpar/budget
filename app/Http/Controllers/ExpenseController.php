<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Budget;
use App\Models\AccountHead;
use App\Models\Transaction;
use App\Models\TransactionEntry;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query()->with(['accountHead', 'department', 'section']);

        // Apply hierarchy-based filtering
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

        // Filtering for reports
        if ($request->filled('division_id')) {
            $query->whereHas('department', function ($q) use ($request) {
                $q->where('division_id', $request->division_id);
            });
        }
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }
        if ($request->filled('account_head_id')) {
            $query->whereHas('transactionEntries', function ($q) use ($request) {
                $q->where('account_head_id', $request->account_head_id);
            });
        }

        // Date range filtering
        if ($request->filled('report_type')) {
            $startDate = now();
            $endDate = now();
            switch ($request->report_type) {
                case 'daily':
                    $startDate = $endDate = $request->filled('date') ? $request->date : now()->toDateString();
                    break;
                case 'weekly':
                    $startDate = now()->startOfWeek();
                    $endDate = now()->endOfWeek();
                    break;
                case 'monthly':
                    $startDate = now()->startOfMonth();
                    $endDate = now()->endOfMonth();
                    break;
                case 'yearly':
                    $startDate = now()->startOfYear();
                    $endDate = now()->endOfYear();
                    break;
                case 'custom':
                    $startDate = $request->start_date;
                    $endDate = $request->end_date;
                    break;
            }
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        $expenses = $query->paginate(10);

        // Calculate totals and remaining budget
        $totalExpenses = $query->sum('amount');
        $budgets = Budget::where('financial_year', now()->year)->get();
        $remainingBudgets = $budgets->mapWithKeys(function ($budget) use ($query) {
            $totalExpenses = $query->whereHas('transactionEntries', function ($q) use ($budget) {
                $q->where('account_head_id', $budget->account_head_id);
            })->sum('amount');
            $budgetLimit = $budget->type === 'revised' ? $budget->amount : (Budget::where('account_head_id', $budget->account_head_id)
                ->where('type', 'revised')
                ->where('financial_year', $budget->financial_year)
                ->first()?->amount ?? $budget->amount);
            return [$budget->account_head_id => $budgetLimit - $totalExpenses];
        });

        // Export to CSV if requested
        if ($request->has('export')) {
            $csvData = $expenses->map(function ($expense) {
                return [
                    'Date' => $expense->transaction_date,
                    'Division' => $expense->department->division->name,
                    'Department' => $expense->department->name,
                    'Section' => $expense->section->name,
                    'Account Head' => $expense->transactionEntries->first()->accountHead->name,
                    'Amount' => $expense->amount,
                    'Status' => $expense->status,
                ];
            })->toArray();

            $csv = "Date,Division,Department,Section,Account Head,Amount,Status\n";
            foreach ($csvData as $row) {
                $csv .= implode(',', $row) . "\n";
            }

            return response($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="expense_report.csv"',
            ]);
        }

        $divisions = Division::all();
        $accountHeads = AccountHead::all();
        return view('expenses.index', compact('expenses', 'divisions', 'accountHeads', 'totalExpenses', 'remainingBudgets'));
    }

    public function create()
    {
        $accountHeads = AccountHead::all();
        $divisions = Division::all();
        return view('expenses.create', compact('accountHeads', 'divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_heads' => 'required|array|min:1',
            'account_heads.*.account_head_id' => 'required|exists:account_heads,id',
            'account_heads.*.amount' => 'required|numeric|min:0.01',
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

            // Determine the current financial year
            $financialYear = now()->year;

            // Check budget limits for each account head
            $errors = [];
            foreach ($request->account_heads as $entry) {
                $accountHeadId = $entry['account_head_id'];
                $amount = $entry['amount'];

                $budget = Budget::where('account_head_id', $accountHeadId)
                    ->where('financial_year', $financialYear)
                    ->where('status', 'active')
                    ->first();

                if (!$budget) {
                    $errors[] = "No active budget found for account head ID {$accountHeadId} in financial year {$financialYear}.";
                    continue;
                }

                $totalExpenses = Expense::whereHas('transactionEntries', function ($q) use ($accountHeadId) {
                    $q->where('account_head_id', $accountHeadId);
                })->where('status', 'approved')->sum('amount');

                $budgetLimit = $budget->type === 'revised' ? $budget->amount : (Budget::where('account_head_id', $accountHeadId)
                    ->where('type', 'revised')
                    ->where('financial_year', $budget->financial_year)
                    ->first()?->amount ?? $budget->amount);

                if ($totalExpenses + $amount > $budgetLimit) {
                    $accountHead = AccountHead::find($accountHeadId);
                    $errors[] = "Expense for {$accountHead->name} exceeds the {$budget->type} budget limit of {$budgetLimit} BDT.";
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
                return redirect()->back()->withErrors(['account_heads' => $errors])->withInput();
            }

            // Create expense and transaction
            $expense = Expense::create([
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

    public function getRemainingBudget($accountHeadId)
    {
        $financialYear = now()->year;
        $budget = Budget::where('account_head_id', $accountHeadId)
            ->where('financial_year', $financialYear)
            ->where('status', 'active')
            ->first();

        if (!$budget) {
            return response()->json(['remaining_budget' => 0], 404);
        }

        $totalExpenses = Expense::whereHas('transactionEntries', function ($q) use ($accountHeadId) {
            $q->where('account_head_id', $accountHeadId);
        })->where('status', 'approved')->sum('amount');

        $budgetLimit = $budget->type === 'revised' ? $budget->amount : (Budget::where('account_head_id', $accountHeadId)
            ->where('type', 'revised')
            ->where('financial_year', $budget->financial_year)
            ->first()?->amount ?? $budget->amount);

        $remainingBudget = $budgetLimit - $totalExpenses;
        return response()->json(['remaining_budget' => $remainingBudget]);
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
