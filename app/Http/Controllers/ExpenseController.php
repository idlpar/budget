<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseApproval;
use App\Models\Budget;
use App\Models\Department;
use App\Models\Section;
use App\Models\AccountHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with(['accountHead', 'budget', 'department', 'section', 'user', 'approver'])->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $budgets = Budget::all();
        $departments = Department::all();
        $sections = Section::all();
        $accountHeads = AccountHead::all();
        return view('expenses.create', compact('budgets', 'departments', 'sections', 'accountHeads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_head_id' => 'required|exists:account_heads,id',
            'budget_id' => 'required|exists:budgets,id',
            'department_id' => 'required|exists:departments,id',
            'section_id' => 'required|exists:sections,id',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
        ]);

        $expense = Expense::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]));

        // Create approval records for section, department, and division levels
        ExpenseApproval::create([
            'expense_id' => $expense->id,
            'approver_id' => Auth::id(), // Replace with actual approver logic
            'level' => 'section',
            'status' => 'pending',
        ]);
        ExpenseApproval::create([
            'expense_id' => $expense->id,
            'approver_id' => Auth::id(), // Replace with actual approver logic
            'level' => 'department',
            'status' => 'pending',
        ]);
        ExpenseApproval::create([
            'expense_id' => $expense->id,
            'approver_id' => Auth::id(), // Replace with actual approver logic
            'level' => 'division',
            'status' => 'pending',
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense submitted successfully.');
    }

    public function approve(Request $request, Expense $expense)
    {
        $level = $request->input('level'); // 'section', 'department', or 'division'
        $approval = $expense->approvals()->where('level', $level)->first();

        if ($approval && $approval->approver_id == Auth::id()) {
            $approval->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            // Check if all approvals are completed
            if ($expense->approvals()->where('status', 'pending')->count() == 0) {
                $expense->update([
                    'status' => 'approved',
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);
            }
        }

        return redirect()->route('expenses.index')->with('success', 'Expense approved at ' . $level . ' level.');
    }

    public function reject(Request $request, Expense $expense)
    {
        $level = $request->input('level');
        $approval = $expense->approvals()->where('level', $level)->first();

        if ($approval && $approval->approver_id == Auth::id()) {
            $approval->update([
                'status' => 'rejected',
                'approved_at' => now(),
            ]);

            $expense->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);
        }

        return redirect()->route('expenses.index')->with('success', 'Expense rejected at ' . $level . ' level.');
    }
}
