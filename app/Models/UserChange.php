<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChange extends Model
{
    protected $table = 'user_changes';

    protected $fillable = [
        'user_id', 'field_name', 'old_value', 'new_value', 'changed_by', 'changed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
