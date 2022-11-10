<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiPraktikum extends Model
{
    use HasFactory;
    protected $fillable = [
        'jadwal_praktikum_id','sesi','jumlah_peserta','jam_mulai','jam_selesai'
    ];

    public function jadwal(){
        return $this->belongsTo(JadwalPraktikum::class);
    }

    public function pesertas(){
        return $this->hasMany(PesertaPraktikum::class);
    }
}
