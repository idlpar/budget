<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentChange extends Model
{
    protected $fillable = ['department_id', 'field_name', 'old_value', 'new_value', 'changed_by'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
