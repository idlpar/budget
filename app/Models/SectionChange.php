<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionChange extends Model
{
    protected $fillable = ['section_id', 'field_name', 'old_value', 'new_value', 'changed_by'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
