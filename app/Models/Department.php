<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}
