<?php

namespace App\Imports;

use App\Models\Budget;
use App\Models\AccountHead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstimatedBudgetImport implements ToModel, WithHeadingRow
{
    protected $financialYear;
    protected $userId;

    public function __construct(string $financialYear, int $userId)
    {
        $this->financialYear = $financialYear;
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        $accountHead = AccountHead::where('account_code', $row['account_code'])->first();
        if (!$accountHead) {
            return null;
        }

        return new Budget([
            'serial' => $row['serial'],
            'account_head_id' => $accountHead->id,
            'account_code' => $row['account_code'],
            'amount' => $row['amount'],
            'type' => 'estimated',
            'financial_year' => $this->financialYear,
            'user_id' => $this->userId,
            'status' => 'active',
        ]);
    }
}
