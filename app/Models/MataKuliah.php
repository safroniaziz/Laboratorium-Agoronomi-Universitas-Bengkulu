<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_mata_kuliah','kode_matkul','prodi_id','semester','sks_praktikum'
    ];

    public function prodi(){
        return $this->belongsTo(Prodi::class);
    }

    public function jadwals(){
        return $this->hasMany(JadwalPraktikum::class);
    }
}
