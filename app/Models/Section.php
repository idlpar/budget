<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
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
