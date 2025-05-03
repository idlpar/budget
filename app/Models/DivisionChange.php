<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionChange extends Model
{
    protected $fillable = ['division_id', 'field_name', 'old_value', 'new_value', 'changed_by'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
