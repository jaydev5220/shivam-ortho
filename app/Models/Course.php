<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'course';

    protected $fillable = [
        'title',
        'short_description',
        'thumbnail',
        'description',
        'video',
        'is_deleted',
        'created_by',
        'updated_by',
    ];

    // Relationship with User (Creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with User (Editor)
    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
