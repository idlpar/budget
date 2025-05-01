<?php
namespace App\Console\Commands;

use App\Models\AccountHead;
use App\Models\Budget;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class StartFinancialYear extends Command
{
    protected $signature = 'budget:start {year} {department_id} {section_id} {user_id}';
    protected $description = 'Start a new financial year with estimated budgets';

    public function handle()
    {
        $year = $this->argument('year');
        $departmentId = $this->argument('department_id');
        $sectionId = $this->argument('section_id');
        $userId = $this->argument('user_id');

        $accountHeads = AccountHead::all();

        foreach ($accountHeads as $head) {
            Budget::create([
                'serial' => Str::uuid()->toString(),
                'account_code' => $head->account_code,
                'account_head_id' => $head->id,
                'amount' => 100000, // Default, replace with dynamic logic
                'type' => 'estimated',
                'financial_year' => $year,
                'status' => 'active',
                'department_id' => $departmentId,
                'section_id' => $sectionId,
                'user_id' => $userId,
            ]);
        }

        $this->info("Financial year {$year} started successfully.");
    }
}
