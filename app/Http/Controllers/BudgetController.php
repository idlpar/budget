<?php
namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Department;
use App\Models\Section;
use App\Models\AccountHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'department_id' => 'required|exists:departments,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        Budget::create(array_merge($validated, ['user_id' => Auth::id()]));

        return redirect()->route('budgets.index')->with('success', 'Budget uploaded successfully.');
    }
}
