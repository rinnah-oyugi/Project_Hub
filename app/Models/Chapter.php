<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    // These fields are now allowed to be saved to the database
    protected $fillable = [
        'user_id',
        'chapter_name',
        'file_path',
        'student_comment',
        'supervisor_comment',
        'status'
    ];

    // This links the chapter back to the student
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}