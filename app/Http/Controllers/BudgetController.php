<?php
namespace App\Http\Controllers;

use App\Imports\EstimatedBudgetImport;
use App\Imports\RevisedBudgetImport;
use App\Models\Budget;
use App\Models\Department;
use App\Models\Section;
use App\Models\AccountHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::with(['accountHead', 'department', 'section', 'user'])->get();
        return view('budgets.index', compact('budgets'));
    }

    public function uploadForm()
    {
        $departments = Department::all();
        $sections = Section::all();
        $accountHeads = AccountHead::all();
        return view('budgets.upload', compact('departments', 'sections', 'accountHeads'));
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'serial' => 'required|string|unique:budgets,serial',
            'account_code' => 'required|string',
            'account_head_id' => 'required|exists:account_heads,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:estimated,revised',
            'financial_year' => 'required|string|regex:/^[0-9]{4}-[0-9]{4}$/',
            'department_id' => 'required|exists:departments,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        Budget::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'active', // Default status for new budgets
        ]));

        return redirect()->route('budgets.index')->with('success', 'Budget uploaded successfully.');
    }

    public function showImportForm()
    {
        $departments = Department::all();
        $sections = Section::all();
        return view('budgets.import', compact('departments', 'sections'));
    }

    public function importEstimated(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'financial_year' => 'required|string|regex:/^[0-9]{4}-[0-9]{4}$/',
            'department_id' => 'required|exists:departments,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        try {
            Excel::import(
                new EstimatedBudgetImport(
                    $request->financial_year,
                    $request->department_id,
                    $request->section_id,
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
            Excel::import(new RevisedBudgetImport($request->financial_year), $request->file('file'));
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
                'account_code' => $budget->account_code,
                'amount' => $request->revised_amount,
                'department_id' => $budget->department_id,
                'section_id' => $budget->section_id,
                'user_id' => $budget->user_id,
                'status' => 'active',
            ]
        );

        return redirect()->route('budgets.index')->with('success', 'Budget revised successfully.');
    }
}
