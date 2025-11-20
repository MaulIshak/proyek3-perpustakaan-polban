<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EJournal extends Model
{
    use HasFactory;

    // Field yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'name',
        'url',
        'description',
        'logo_path',
        'type',
    ];

    // Append atribut custom 'img_url' ke dalam JSON response
    protected $appends = ['img_url'];

    /**
     * Accessor untuk mengubah 'logo_path' menjadi URL lengkap untuk Vue.
     * Di Vue nanti panggilnya: journal.img_url
     */
    protected function getImgUrlAttribute()
    {
        if ($this->logo_path) {
            return url('storage/' . $this->logo_path);
        }
        
        return null; // Atau return URL placeholder default jika mau
    }
}