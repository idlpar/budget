<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseApproval extends Model
{
    protected $fillable = ['expense_id', 'approver_id', 'level', 'status', 'approved_at'];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
