<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCover extends Model
{
    // Izinkan kolom ini untuk diisi
    protected $fillable = [
        'title', 
        'image_path'
    ];
}
