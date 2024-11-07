<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDiri extends Model
{
    use HasFactory;

    protected $fillable = [
        'kecamatan',
        'desa',
        'nama_lengkap',
        'foto_ktp',
        'foto_diri',
        'user_id',
    ];
}
