<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\AccountHead;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function expense(Request $request)
    {
        $category = $request->input('category', 'account_head');
        $period = $request->input('period', 'day');
        $startDate = $request->input('start_date', now()->startOfDay()->toDateString());
        $endDate = $request->input('end_date', now()->endOfDay()->toDateString());

        $query = Expense::query()->where('status', 'approved')
            ->with(['transaction.entries.accountHead', 'department', 'section', 'budget']);

        // Apply hierarchy scoping
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

        // Apply date range
        switch ($period) {
            case 'day':
                $query->whereDate('transaction_date', $startDate);
                break;
            case 'week':
                $query->whereBetween('transaction_date', [
                    Carbon::parse($startDate)->startOfWeek(),
                    Carbon::parse($startDate)->endOfWeek(),
                ]);
                break;
            case 'month':
                $query->whereBetween('transaction_date', [
                    Carbon::parse($startDate)->startOfMonth(),
                    Carbon::parse($startDate)->endOfMonth(),
                ]);
                break;
            case 'year':
                $query->whereBetween('transaction_date', [
                    Carbon::parse($startDate)->startOfYear(),
                    Carbon::parse($startDate)->endOfYear(),
                ]);
                break;
            case 'custom':
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
                break;
        }

        $expenses = $query->get();
        $totalRows = $expenses->count();
        $totalByHead = $expenses->flatMap(function ($expense) {
            return $expense->transaction->entries->map(function ($entry) {
                return [
                    'account_head' => $entry->accountHead->name,
                    'amount' => $entry->debit,
                ];
            });
        })->groupBy('account_head')->map(function ($group) {
            return number_format($group->sum('amount'), 2);
        });
        $totalExpenditure = number_format($totalByHead->sum(), 2);

        return view('reports.expense', compact('expenses', 'category', 'period', 'startDate', 'endDate', 'totalRows', 'totalByHead', 'totalExpenditure'));
    }

    public function accountHeadDetail(Request $request, AccountHead $accountHead)
    {
        $period = $request->input('period', 'day');
        $startDate = $request->input('start_date', now()->startOfDay()->toDateString());
        $endDate = $request->input('end_date', now()->endOfDay()->toDateString());

        $query = TransactionEntry::query()
            ->where('account_head_id', $accountHead->id)
            ->whereHas('transaction.expense', function ($q) {
                $q->where('status', 'approved');
            })
            ->with(['transaction.expense']);

        // Apply hierarchy scoping
        if (!auth()->user()->is_admin) {
            $query->whereHas('transaction.expense', function ($q) {
                if (auth()->user()->division_id) {
                    $q->whereHas('department', function ($dq) {
                        $dq->where('division_id', auth()->user()->division_id);
                    });
                }
                if (auth()->user()->department_id) {
                    $q->where('department_id', auth()->user()->department_id);
                }
                if (auth()->user()->section_id) {
                    $q->where('section_id', auth()->user()->section_id);
                }
            });
        }

        // Apply date range
        switch ($period) {
            case 'day':
                $query->whereHas('transaction', function ($q) use ($startDate) {
                    $q->whereDate('transaction_date', $startDate);
                });
                break;
            case 'week':
                $query->whereHas('transaction', function ($q) use ($startDate) {
                    $q->whereBetween('transaction_date', [
                        Carbon::parse($startDate)->startOfWeek(),
                        Carbon::parse($startDate)->endOfWeek(),
                    ]);
                });
                break;
            case 'month':
                $query->whereHas('transaction', function ($q) use ($startDate) {
                    $q->whereBetween('transaction_date', [
                        Carbon::parse($startDate)->startOfMonth(),
                        Carbon::parse($startDate)->endOfMonth(),
                    ]);
                });
                break;
            case 'year':
                $query->whereHas('transaction', function ($q) use ($startDate) {
                    $q->whereBetween('transaction_date', [
                        Carbon::parse($startDate)->startOfYear(),
                        Carbon::parse($startDate)->endOfYear(),
                    ]);
                });
                break;
            case 'custom':
                $query->whereHas('transaction', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('transaction_date', [$startDate, $endDate]);
                });
                break;
        }

        $entries = $query->get();
        $total = number_format($entries->sum('debit'), 2);

        return view('reports.account-head', compact('accountHead', 'entries', 'period', 'startDate', 'endDate', 'total'));
    }
}
