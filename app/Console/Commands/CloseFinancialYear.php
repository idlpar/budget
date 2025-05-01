<?php
namespace App\Console\Commands;

use App\Models\Budget;
use Illuminate\Console\Command;

class CloseFinancialYear extends Command
{
    protected $signature = 'budget:close {year}';
    protected $description = 'Close budgets for a financial year';

    public function handle()
    {
        $year = $this->argument('year');
        Budget::where('financial_year', $year)->update(['status' => 'closed']);
        $this->info("Financial year {$year} closed successfully.");
    }
}
