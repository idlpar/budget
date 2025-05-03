<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'previous_name', 'email', 'email_verified_at', 'avatar', 'password',
        'name_changed_at', 'is_admin', 'created_by', 'name_changed_by',
        'role', 'division_id', 'department_id', 'section_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'name_changed_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    // Relationships
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }



    public function isSectionHead()
    {
        return $this->hasRole('section_head');
    }

    public function isStaff()
    {
        return $this->hasRole('staff');
    }
    public function isAdmin()
    {
        return $this->is_admin;
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function changes(): HasMany
    {
        return $this->hasMany(UserChange::class, 'user_id');
    }

    public function nameChangedBy()
    {
        return $this->belongsTo(User::class, 'name_changed_by');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
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
