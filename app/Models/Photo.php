<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use SoftDeletes;

    protected $table = 'photos';

    // migration menggunakan foto_id uuid
    protected $primaryKey = 'foto_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // custom timestamps
    const CREATED_AT = 'created_date';
    const UPDATED_AT = null; // tidak ada updated default
    const DELETED_AT = 'deleted_date';

    protected $fillable = [
        'foto_id',
        'url_foto',
        'size',
        'tipe',
    ];

    protected $dates = [
        'created_date',
        'deleted_date',
    ];
}