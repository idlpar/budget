<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionEntry extends Model
{
    protected $fillable = ['transaction_id', 'account_head_id', 'debit', 'credit', 'expense_id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function accountHead()
    {
        return $this->belongsTo(AccountHead::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
