<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Budget;
use App\Models\AccountHead;
use App\Models\Transaction;
use App\Models\TransactionEntry;
use App\Models\Division;
use App\Models\Department;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query()->with(['accountHead', 'department', 'section', 'transaction']);

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
            $query->where('account_head_id', $request->account_head_id);
        }

        $reportType = $request->input('report_type', 'daily');
        $startDate = now();
        $endDate = now();
        switch ($reportType) {
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

        $expenses = $query->orderBy('transaction_date', 'desc')->paginate(10);

        $totalExpenses = $query->sum('amount');
        $budgets = Budget::where('financial_year', now()->year)->get();
        $remainingBudgets = $budgets->mapWithKeys(function ($budget) use ($query) {
            $totalExpenses = $query->where('account_head_id', $budget->account_head_id)->sum('amount');
            $budgetLimit = $budget->type === 'revised' ? $budget->amount : (Budget::where('account_head_id', $budget->account_head_id)
                ->where('type', 'revised')
                ->where('financial_year', $budget->financial_year)
                ->first()?->amount ?? $budget->amount);
            return [$budget->account_head_id => $budgetLimit - $totalExpenses];
        });

        if ($request->has('export')) {
            $csvData = $expenses->map(function ($expense) {
                return [
                    'Date' => $expense->transaction_date,
                    'Transaction ID' => $expense->transaction_id,
                    'Division' => $expense->department->division->name,
                    'Department' => $expense->department->name,
                    'Section' => $expense->section->name ?? 'N/A',
                    'Account Head' => $expense->accountHead->name,
                    'Amount' => $expense->amount,
                    'Description' => $expense->transaction->description,
                    'Status' => $expense->status,
                ];
            })->toArray();

            $csv = "Date,Transaction ID,Division,Department,Section,Account Head,Amount,Description,Status\n";
            foreach ($csvData as $row) {
                $csv .= implode(',', array_map('strval', $row)) . "\n";
            }

            return response($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="expense_report.csv"',
            ]);
        }

        $divisions = Division::all();
        $departments = Department::all();
        $sections = Section::all();
        $accountHeads = AccountHead::all();
        return view('expenses.index', compact('expenses', 'divisions', 'departments', 'sections', 'accountHeads', 'totalExpenses', 'remainingBudgets', 'reportType', 'startDate', 'endDate'));
    }

    public function create(Request $request)
    {
        $financialYear = $request->input('financial_year', '2023-2024');

        $financialYears = Budget::select('financial_year')
            ->distinct()
            ->pluck('financial_year')
            ->filter()
            ->sort()
            ->values();

        $budgets = Budget::with('accountHead')
            ->where('financial_year', $financialYear)
            ->where('status', 'active')
            ->whereIn('type', ['estimated', 'revised'])
            ->get()
            ->sortBy(function ($budget) {
                return $budget->accountHead ? $budget->accountHead->name : '';
            });

        \Log::info('Budget query details', [
            'financial_year' => $financialYear,
            'budget_count' => $budgets->count(),
            'budget_ids' => $budgets->pluck('id')->toArray(),
            'account_head_ids' => $budgets->pluck('account_head_id')->toArray(),
        ]);

        $user = auth()->user();
        $sectionsQuery = Section::query();
        $departmentsQuery = Department::query();

        if (!$user->is_admin) {
            if ($user->division_id) {
                $departmentsQuery->where('division_id', $user->division_id);
                $sectionsQuery->whereHas('department', function ($q) use ($user) {
                    $q->where('division_id', $user->division_id);
                });
            }
            if ($user->department_id) {
                $sectionsQuery->where('department_id', $user->department_id);
                $departmentsQuery->where('id', $user->department_id);
            }
            if ($user->section_id) {
                $sectionsQuery->where('id', $user->section_id);
            }
        }

        $sections = $sectionsQuery->get();
        $departments = $departmentsQuery->get();
        $divisions = $user->is_admin ? Division::all() : Division::where('id', $user->division_id)->get();

        \Log::info('Hierarchy data', [
            'user_id' => $user->id,
            'is_admin' => $user->is_admin,
            'division_id' => $user->division_id,
            'department_id' => $user->department_id,
            'section_id' => $user->section_id,
            'section_count' => $sections->count(),
            'department_count' => $departments->count(),
            'division_count' => $divisions->count(),
            'department_ids' => $departments->pluck('id')->toArray(),
        ]);

        return view('expenses.create', compact('budgets', 'divisions', 'departments', 'sections', 'financialYears', 'financialYear'));
    }

    public function store(Request $request)
    {
        \Log::info('Store request data', [
            'section_id' => $request->section_id,
            'department_id' => $request->department_id,
            'department_id_alt' => $request->department_id_alt,
            'division_id' => $request->division_id,
            'division_id_alt' => $request->division_id_alt,
            'financial_year' => $request->financial_year,
            'budget_heads' => $request->budget_heads,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
        ]);

        $validator = Validator::make($request->all(), [
            'financial_year' => 'required|string|regex:/^[0-9]{4}-[0-9]{4}$/',
            'budget_heads' => 'required|array|min:1',
            'budget_heads.*.account_head_id' => 'required|exists:account_heads,id',
            'budget_heads.*.raw_amount' => 'required|numeric|min:0.01',
            'section_id' => 'nullable|exists:sections,id',
            'department_id' => 'nullable|exists:departments,id',
            'department_id_alt' => 'nullable|exists:departments,id',
            'division_id' => 'nullable|exists:divisions,id',
            'division_id_alt' => 'nullable|exists:divisions,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ], [
            'department_id_alt.exists' => 'The selected department is invalid.',
            'department_id.exists' => 'The department associated with the section is invalid.',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed', ['errors' => $validator->errors()->toArray()]);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $departmentId = $request->section_id ? $request->department_id : $request->department_id_alt;
            $sectionId = $request->section_id ?: null;

            if ($sectionId && !$departmentId) {
                throw new \Exception('Department ID is required when a section is selected.');
            }

            if ($sectionId) {
                $section = Section::findOrFail($sectionId);
                if ($section->department_id != $departmentId) {
                    \Log::error('Section department mismatch', [
                        'section_id' => $sectionId,
                        'department_id' => $departmentId,
                        'section_department_id' => $section->department_id,
                    ]);
                    throw new \Exception('Selected section does not belong to the chosen department.');
                }
            } elseif (!$departmentId) {
                throw new \Exception('No department selected.');
            }

            $errors = [];
            $budgetIds = [];
            foreach ($request->budget_heads as $entry) {
                $accountHeadId = $entry['account_head_id'];
                $amount = $entry['raw_amount'];

                $budget = Budget::where('account_head_id', $accountHeadId)
                    ->where('financial_year', $request->financial_year)
                    ->where('status', 'active')
                    ->orderByRaw("CASE WHEN type = 'revised' THEN 1 WHEN type = 'estimated' THEN 2 ELSE 3 END")
                    ->first();

                if (!$budget) {
                    $errors[] = "No active budget found for budget head ID {$accountHeadId} in financial year {$request->financial_year}.";
                    continue;
                }

                $budgetIds[] = $budget->id;

                $totalExpenses = Expense::where('account_head_id', $accountHeadId)
                    ->where('financial_year', $request->financial_year)
                    ->where('status', 'approved')
                    ->sum('amount');

                $budgetLimit = $budget->amount;
                if ($totalExpenses + $amount > $budgetLimit) {
                    $accountHead = AccountHead::find($accountHeadId);
                    $errors[] = "Expense for {$accountHead->name} exceeds the {$budget->type} budget limit of {$budgetLimit} BDT.";
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
                return redirect()->back()->withErrors(['budget_heads' => $errors])->withInput();
            }

            $transaction = Transaction::create([
                'section_id' => $sectionId,
                'transaction_date' => $request->transaction_date,
                'description' => $request->description ?? 'Expense transaction',
                'created_by' => auth()->id(),
            ]);

            $maxSerial = Expense::where('financial_year', $request->financial_year)
                ->max('serial') ?? 0;
            $serial = $maxSerial + 1;

            foreach ($request->budget_heads as $index => $entry) {
                $expense = Expense::create([
                    'account_head_id' => $entry['account_head_id'],
                    'budget_id' => $budgetIds[$index],
                    'department_id' => $departmentId,
                    'section_id' => $sectionId,
                    'serial' => $serial,
                    'financial_year' => $request->financial_year,
                    'amount' => $entry['raw_amount'],
                    'transaction_date' => $request->transaction_date,
                    'user_id' => auth()->id(),
                    'status' => 'pending',
                    'transaction_id' => $transaction->id,
                ]);

                TransactionEntry::create([
                    'transaction_id' => $transaction->id,
                    'account_head_id' => $entry['account_head_id'],
                    'debit' => $entry['raw_amount'],
                    'expense_id' => $expense->id,
                ]);

                $serial++;
            }

            Log::info('Expenses recorded', [
                'transaction_id' => $transaction->id,
                'user_id' => auth()->id(),
                'financial_year' => $request->financial_year,
                'budget_heads' => $request->budget_heads,
                'department_id' => $departmentId,
                'section_id' => $sectionId,
                'serial_start' => $maxSerial + 1,
                'serial_end' => $serial - 1,
            ]);

            DB::commit();
            return redirect()->route('expenses.index')->with('success', 'Expenses recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Expense creation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to record expenses: ' . $e->getMessage());
        }
    }

    public function register(Request $request)
    {
        $query = Expense::query()->with(['transaction', 'department', 'section']);

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

        return view('expenses.register', compact('expenses'));
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

            $totalExpenses = Expense::where('account_head_id', $accountHeadId)
                ->where('financial_year', $financialYear)
                ->where('status', 'approved')
                ->sum('amount');

            $remainingBudget = $budget->amount - $totalExpenses;

            \Log::info('Remaining budget calculated', [
                'account_head_id' => $accountHeadId,
                'financial_year' => $financialYear,
                'budget_amount' => $budget->amount,
                'total_expenses' => $totalExpenses,
                'remaining_budget' => $remainingBudget,
            ]);

            return response()->json(['remaining_budget' => $remainingBudget]);
        } catch (\Exception $e) {
            \Log::error('Error calculating remaining budget', [
                'account_head_id' => $accountHeadId,
                'financial_year' => $financialYear,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Unable to calculate remaining budget: ' . $e->getMessage()], 500);
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
