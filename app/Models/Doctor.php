<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctor';

    protected $fillable = [
        'name',
        'specialization',
        'image',
        'description',
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
