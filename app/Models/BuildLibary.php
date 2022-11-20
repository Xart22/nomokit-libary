<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildLibary extends Model
{
    use HasFactory;
    protected $table = 'build_libaries';
    protected $fillable = [
        'released_version',
        'file_path',
        'id_libaries',
        'is_active',
        'created_at',
    ];
}
