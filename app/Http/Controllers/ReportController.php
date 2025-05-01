<?php
namespace App\Http\Controllers;

use App\Models\AccountHead;
use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $accountHeads = AccountHead::all();
        $reports = [];

        if ($request->has('account_head_id')) {
            $request->validate([
                'account_head_id' => 'required|exists:account_heads,id',
                'type' => 'required|in:daily,weekly,monthly,yearly,custom',
                'start_date' => 'required_if:type,custom|date',
                'end_date' => 'required_if:type,custom|date|after_or_equal:start_date',
            ]);

            $accountHead = AccountHead::findOrFail($request->account_head_id);
            $type = $request->type;
            $query = Expense::where('account_head_id', $accountHead->id)
                ->where('status', 'approved');

            if ($type === 'custom') {
                $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
            } elseif ($type === 'daily') {
                $query->selectRaw('DATE(transaction_date) as period, SUM(amount) as total')
                    ->groupBy('period');
            } elseif ($type === 'weekly') {
                $query->selectRaw('YEARWEEK(transaction_date) as period, SUM(amount) as total')
                    ->groupBy('period');
            } elseif ($type === 'monthly') {
                $query->selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as period, SUM(amount) as total')
                    ->groupBy('period');
            } elseif ($type === 'yearly') {
                $query->selectRaw('YEAR(transaction_date) as period, SUM(amount) as total')
                    ->groupBy('period');
            }

            $reports = $query->get();
            $budget = Budget::where('account_head_id', $accountHead->id)
                ->where('status', 'active')
                ->where('type', 'estimated')
                ->first();
            $budgetAmount = $budget ? ($budget->type === 'revised' ? $budget->amount : Budget::where('account_head_id', $accountHead->id)
                ->where('financial_year', $budget->financial_year)
                ->where('type', 'revised')
                ->first()->amount ?? $budget->amount) : 0;
            $totalSpent = $reports->sum('total');
            $remaining = $budgetAmount - $totalSpent;
        }

        return view('reports.index', compact('accountHeads', 'reports', 'budgetAmount', 'totalSpent', 'remaining', 'type'));
    }
}
