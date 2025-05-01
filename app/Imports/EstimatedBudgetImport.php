<?php

namespace App\Imports;

use App\Models\Budget;
use App\Models\AccountHead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstimatedBudgetImport implements ToModel, WithHeadingRow
{
    protected $financial_year;
    protected $user_id;

    public function __construct($financial_year, $user_id)
    {
        $this->financial_year = $financial_year;
        $this->user_id = $user_id;
    }

    public function model(array $row)
    {
        $accountHead = AccountHead::where('account_code', $row['account_code'])->first();

        if (!$accountHead) {
            return null; // Skip rows with invalid account codes
        }

        return new Budget([
            'serial' => $row['serial'],
            'account_head_id' => $accountHead->id,
            'account_code' => $row['account_code'], // Add this line
            'amount' => $row['amount'],
            'type' => 'estimated',
            'financial_year' => $this->financial_year,
            'user_id' => $this->user_id,
            'status' => 'active',
        ]);
    }
}
