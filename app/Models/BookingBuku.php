<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingBuku extends Model
{
    protected $table = 'bookings'; // Pastikan ini ada

    protected $fillable = [
        'nama_lengkap',
        'nim_nip',
        'email',
        'whatsapp',
        'judul_buku',
        'pengarang',
        'status',
        'rejection_reason',
        'deadline'
    ];
}