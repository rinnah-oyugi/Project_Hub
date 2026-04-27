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
        'proposal_student_comment',
        'proposal_supervisor_comment',
        'proposal_status',
        'proposal_file_path',
        'request_status',
        'phone',
        'address',
        'emergency_contact',
        'emergency_phone',
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

    /**
     * Relationship: Connects Supervisor to their assigned Students
     */
    public function students()
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function hasProposal(): bool
    {
        return ! empty($this->project_title);
    }

    /**
     * Get the user's status with proper formatting
     */
    public function getStatusAttribute(): string
    {
        if ($this->role === 'student') {
            return 'active';
        }
        
        return $this->is_approved ? 'active' : 'suspended';
    }

    /**
     * Get the user's status with proper display formatting
     */
    public function getDisplayStatusAttribute(): string
    {
        if ($this->role === 'student') {
            return 'Active';
        }
        
        if ($this->role === 'admin') {
            return 'Admin';
        }
        
        return $this->is_approved ? 'Active' : 'Suspended';
    }

    /**
     * Get the user's status color class
     */
    public function getStatusColorAttribute(): string
    {
        if ($this->role === 'student') {
            return 'emerald';
        }
        
        if ($this->role === 'admin') {
            return 'indigo';
        }
        
        return $this->is_approved ? 'emerald' : 'amber';
    }
}