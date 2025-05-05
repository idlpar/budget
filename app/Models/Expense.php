<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_head_id', 'budget_id', 'department_id', 'section_id', 'serial',
        'financial_year', 'amount', 'transaction_date', 'user_id', 'status',
        'approved_by', 'approved_at', 'transaction_id'
    ];

    public function accountHead()
    {
        return $this->belongsTo(AccountHead::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
