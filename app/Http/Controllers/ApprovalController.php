<?php
namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Department;
use App\Models\Section;
use App\Models\AccountHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index()
    {
        $approvals = Approval::with(['accountHead', 'department', 'section', 'user'])
            ->orderBy('transaction_date', 'desc')
            ->get();
        return view('expenses.index', compact('approvals'));
    }

    public function create()
    {
        $departments = Department::all();
        $sections = Section::all();
        $accountHeads = AccountHead::all();
        return view('expenses.create', compact('departments', 'sections', 'accountHeads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_head_id' => 'required|exists:account_heads,id',
            'department_id' => 'required|exists:departments,id',
            'section_id' => 'required|exists:sections,id',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
        ]);

        Approval::create(array_merge($validated, ['user_id' => Auth::id()]));

        return redirect()->route('expenses.index')->with('success', 'Approval posted successfully.');
    }
}
