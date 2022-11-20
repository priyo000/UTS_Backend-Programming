<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pasien extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pasien',
        'no_hp',
        'alamat',
        'status_id',
        'tgl_masuk',
        'tgl_keluar'
    ];

    function status(){
        $this->belongsTo(Status::class);

    }

    protected $table = 'pasien';
}