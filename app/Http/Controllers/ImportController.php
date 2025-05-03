<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OrganogramImport;

class ImportController extends Controller
{
    public function showImportForm()
    {
        Log::info('Import form accessed', ['user_id' => auth()->id()]);
        return view('imports.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'type' => 'required|in:organogram',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();
            if ($request->type === 'organogram') {
                Excel::import(new OrganogramImport, $request->file('file'));
            }
            Log::info('Import successful', ['user_id' => auth()->id(), 'type' => $request->type]);
            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('imports.index')->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error('Import failed', [
                'user_id' => auth()->id(),
                'type' => $request->type,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Failed to import data: ' . $e->getMessage());
        }
    }
}
