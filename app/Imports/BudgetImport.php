<?php
namespace App\Imports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class BudgetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Budget([
            'serial' => $row['serial'],
            'account_code' => $row['account_code'],
            'account_head_id' => $row['account_head_id'],
            'amount' => $row['amount'],
            'type' => $row['type'],
            'department_id' => $row['department_id'],
            'section_id' => $row['section_id'],
            'user_id' => Auth::id(),
        ]);
    }
}
