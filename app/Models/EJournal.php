<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',              // URL Utama
        'additional_links', // [BARU] JSON Array
        'description',
        'logo_path',
        'type',
    ];

    // [PENTING] Ubah JSON jadi Array otomatis
    protected $casts = [
        'additional_links' => 'array',
    ];

    protected $appends = ['img_url'];

    protected function getImgUrlAttribute()
    {
        if ($this->logo_path) {
            return url('storage/' . $this->logo_path);
        }
        return null; 
    }
}