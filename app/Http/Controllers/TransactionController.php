<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index()
    {
        $query = Transaction::query()->with(['entries.accountHead', 'section']);

        if (!auth()->user()->is_admin) {
            if (auth()->user()->division_id) {
                $query->whereHas('section.department', function ($q) {
                    $q->where('division_id', auth()->user()->division_id);
                });
            }
            if (auth()->user()->department_id) {
                $query->whereHas('section', function ($q) {
                    $q->where('department_id', auth()->user()->department_id);
                });
            }
            if (auth()->user()->section_id) {
                $query->where('section_id', auth()->user()->section_id);
            }
        }

        $transactions = $query->paginate(10);
        Log::info('Transactions index accessed', ['user_id' => auth()->id()]);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        // Transactions are created via expenses, so redirect to expense creation
        return redirect()->route('expenses.create');
    }

    public function store(Request $request)
    {
        // Transactions are created via expenses, so this method is not used
        return redirect()->route('expenses.create');
    }
}
