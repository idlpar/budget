<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHeadChange extends Model
{
    protected $fillable = [
        'account_head_id',
        'field_name',
        'old_value',
        'new_value',
        'changed_by',
        'changed_at',
    ];

    public function accountHead()
    {
        return $this->belongsTo(AccountHead::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
