<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'photos';
    protected $primaryKey = 'foto_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'url_foto',
        'size',
        'tipe',
    ];
}
