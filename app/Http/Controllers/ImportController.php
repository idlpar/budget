<?php
namespace App\Http\Controllers;

use App\Imports\BudgetImport;
use App\Imports\EmployeeCostImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function showImportForm()
    {
        return view('imports.index');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'table' => 'required|in:budgets,employee_costs',
        ]);

        try {
            if ($validated['table'] === 'budgets') {
                Excel::import(new BudgetImport, $request->file('file'));
            } elseif ($validated['table'] === 'employee_costs') {
                Excel::import(new EmployeeCostImport, $request->file('file'));
            }

            return redirect()->back()->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
}
