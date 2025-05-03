<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $fillable = ['department_id', 'name', 'created_by', 'updated_by'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function changes()
    {
        return $this->hasMany(SectionChange::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

}
