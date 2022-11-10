<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPraktikum extends Model
{
    use HasFactory;

    protected $fillable = [
        'sesi_praktikum_id','nama_lengkap','npm','prodi'
    ];

    public function sesi(){
        return $this->belongsTo(SesiPraktikum::class);
    }
}
