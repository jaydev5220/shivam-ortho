<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'cms';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
}
