<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeCost extends Model
{
    protected $fillable = ['employee_id', 'cost', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
