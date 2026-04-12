<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Merged Fillable Fields:
     * Includes your 
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'university_id',
        'department',
        'is_approved',
        'supervisor_id',
        'project_title',
        'project_description',
        'request_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    /**
     * Relationship: Connects the Student to their chosen Supervisor
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function hasProposal(): bool
    {
        return ! empty($this->project_title);
    }
}