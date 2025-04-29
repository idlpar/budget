<?php
namespace App\Imports;

use App\Models\EmployeeCost;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeCostImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new EmployeeCost([
            'employee_id' => $row['employee_id'],
            'cost' => $row['cost'],
            'department_id' => $row['department_id'],
        ]);
    }
}
