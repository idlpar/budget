<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHead extends Model
{
    protected $fillable = ['name', 'code'];

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}
