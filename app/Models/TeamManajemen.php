<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamManajemen extends Model
{
    protected $table = 'team_manajemen';
    protected $primaryKey = 'id_team';
    public $timestamps = false;

    // Kolom yang boleh diisi massal (dari form)
    protected $fillable = [
        'nama',
        'jabatan',
        'gelar',
    ];
}
