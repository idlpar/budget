<?php
namespace App\Imports;

use App\Models\AccountHead;
use App\Models\Budget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RevisedBudgetImport implements ToModel, WithHeadingRow
{
    protected $financialYear;

    public function __construct($financialYear)
    {
        $this->financialYear = $financialYear;
    }

    public function model(array $row)
    {
        $code = (string) $row['code'];

        $accountHead = AccountHead::where('account_code', $code)->first();
        if (!$accountHead) {
            return null;
        }

        $budget = Budget::where('account_head_id', $accountHead->id)
            ->where('financial_year', $this->financialYear)
            ->where('type', 'estimated')
            ->first();

        if ($budget) {
            $revisedAmount = $row['estimated_budget_lac'] * 100000;

            Budget::updateOrCreate(
                [
                    'account_head_id' => $accountHead->id,
                    'financial_year' => $this->financialYear,
                    'type' => 'revised',
                ],
                [
                    'serial' => $budget->serial,
                    'account_code' => $code,
                    'amount' => $revisedAmount,
                    'department_id' => $budget->department_id,
                    'section_id' => $budget->section_id,
                    'user_id' => $budget->user_id,
                    'status' => 'active',
                ]
            );
        }

        return $budget;
    }
}
