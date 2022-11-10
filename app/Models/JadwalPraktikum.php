<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPraktikum extends Model
{
    use HasFactory;

    protected $dates = ['tanggal_praktikum'];

    protected $fillable = [
        'mata_kuliah_id','tanggal_praktikum','jumlah_sesi'
    ];

    public function matkul(){
        return $this->belongsTo(MataKuliah::class);
    }

    public function sesis(){
        return $this->hasMany(SesiPraktikum::class);
    }
}
