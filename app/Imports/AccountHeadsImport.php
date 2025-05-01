<?php

namespace App\Imports;

use App\Models\AccountHead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountHeadsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::debug('Processing Excel row', [
            'row' => $row,
            'code_type' => gettype($row['code']),
            'code_value' => $row['code'],
        ]);

        $accountCode = !is_null($row['code']) ? (string) $row['code'] : null;

        Log::debug('Processed account code', [
            'account_code' => $accountCode,
            'account_code_type' => gettype($accountCode),
        ]);

        return new AccountHead([
            'account_code' => $accountCode,
            'name' => $row['name'],
            'type' => $row['type'],
            'created_by' => Auth::id(),
            'updated_by' => null,
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
