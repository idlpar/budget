<?php
namespace App\Imports;

use App\Models\AccountHead;
use App\Models\Budget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class EstimatedBudgetImport implements ToModel, WithHeadingRow
{
    protected $financialYear;
    protected $departmentId;
    protected $sectionId;
    protected $userId;

    public function __construct($financialYear, $departmentId, $sectionId, $userId)
    {
        $this->financialYear = $financialYear;
        $this->departmentId = $departmentId;
        $this->sectionId = $sectionId;
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        $code = (string) $row['code'];

        $accountHead = AccountHead::firstOrCreate(
            ['account_code' => $code],
            ['name' => $row['name_of_account'], 'type' => 'expense', 'created_by' => $this->userId]
        );

        $estimatedAmount = $row['estimated_budget_lac'] * 100000;

        return Budget::updateOrCreate(
            [
                'account_head_id' => $accountHead->id,
                'financial_year' => $this->financialYear,
                'type' => 'estimated',
            ],
            [
                'serial' => Str::uuid()->toString(),
                'account_code' => $code,
                'amount' => $estimatedAmount,
                'department_id' => $this->departmentId,
                'section_id' => $this->sectionId,
                'user_id' => $this->userId,
                'status' => 'active',
            ]
        );
    }
}
