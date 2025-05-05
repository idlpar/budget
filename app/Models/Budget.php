<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'serial', 'account_code', 'account_head_id', 'amount', 'type',
        'financial_year', 'status', 'user_id'
    ];

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
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

}
