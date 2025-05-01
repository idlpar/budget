<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHead extends Model
{
    protected $fillable = [
        'account_code',
        'name',
        'type',
        'created_by',
        'updated_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function changes()
    {
        return $this->hasMany(AccountHeadChange::class, 'account_head_id');
    }
}
