<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pengusul',
        'nim',
        'prodi',
        'title',
        'author',
        'isbn',
        'publisher',
        'year',
        'price',
        'reason',
        'cover_image',
        'description',
        'status', 
    ];

    // Mengubah format tanggal secara otomatis jika perlu
    protected $casts = [
        'created_at' => 'datetime',
    ];
}