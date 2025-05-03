<?php

namespace App\Imports;

use App\Models\Budget;
use App\Models\AccountHead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RevisedBudgetImport implements ToModel, WithHeadingRow
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

        return Budget::updateOrCreate(
            [
                'account_head_id' => $accountHead->id,
                'financial_year' => $this->financialYear,
                'type' => 'revised',
            ],
            [
                'serial' => $row['serial'],
                'account_code' => $row['account_code'],
                'amount' => $row['amount'],
                'user_id' => $this->userId,
                'status' => 'active',
            ]
        );
    }
}
