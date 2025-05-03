<?php

namespace App\Imports;

use App\Models\Division;
use App\Models\Department;
use App\Models\Section;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class OrganogramImport implements ToModel, WithHeadingRow
{
    protected $rowCount = 0;

    public function model(array $row)
    {
        // Check if required columns are present
        if (!isset($row['division']) || !isset($row['department']) || !isset($row['section'])) {
            return null;
        }

        // Create or get the Division
        $division = Division::updateOrCreate(
            ['name' => $row['division']],
            ['created_by' => Auth::id()]
        );

        // Create or get the Department
        $department = Department::updateOrCreate(
            [
                'name' => $row['department'],
                'division_id' => $division->id,
            ],
            ['created_by' => Auth::id()]
        );

        // Create or get the Section
        $section = Section::updateOrCreate(
            [
                'name' => $row['section'],
                'department_id' => $department->id,
            ],
            ['created_by' => Auth::id()]
        );

        // Increment the row counter if a section was created or updated
        if ($section) {
            $this->rowCount++;
        }

        return $section;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }
}
