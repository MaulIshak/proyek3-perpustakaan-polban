<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCover extends Model
{
    // Izinkan kolom ini untuk diisi
    protected $fillable = [
        'image_path',
        'link_buku'
    ];
}
