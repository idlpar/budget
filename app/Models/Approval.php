<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        'account_head_id', 'department_id', 'section_id', 'amount',
        'transaction_date', 'user_id',
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
}
