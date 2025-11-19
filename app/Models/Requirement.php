<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'course_requirement',
        'type',       // 'text' or 'upload'
        'file_path',
        'user_id'
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helpers (optional)
    public function isText(): bool
    {
        return $this->type === 'text';
    }

    public function isUpload(): bool
    {
        return $this->type === 'upload';
    }
}
