<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'account_head_id', 'budget_id', 'department_id', 'section_id',
        'amount', 'transaction_date', 'user_id', 'status', 'approved_by', 'approved_at'
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function accountHead()
    {
        return $this->belongsTo(AccountHead::class);
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

    public function approvals()
    {
        return $this->hasMany(ExpenseApproval::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
