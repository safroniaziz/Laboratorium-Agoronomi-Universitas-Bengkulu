<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\PesertaPraktikum;
use App\Models\Prodi;
use App\Models\SesiPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MahasiswaDashboardController extends Controller
{
    public function __construct() {
        $this->middleware('isMahasiswa');
    }

    public function dashboard(){
        $prodi = Prodi::select('id')->where('kode_prodi',Session::get('kode_prodi'))->first();
        $matkuls = MataKuliah::where('prodi_id',$prodi->id)->get();
        return view('mahasiswa.dashboard',[
            'matkuls'  =>  $matkuls
        ]);
    }

    public function matkulDetail($matkul_id){
        $matkul = MataKuliah::where('id',$matkul_id)->first();
        return view('mahasiswa/matkul_detail',[
            'matkul' => $matkul,
            'matkul_id' => $matkul_id,
        ]);
    }

    public function cariSesi(Request $request){
        $sesis = SesiPraktikum::where('jadwal_praktikum_id',$request->jadwal_id)->get();
        return $sesis;
    }

    public function cariDetail(Request $request,$matkul_id){
        $attributes = [
            'jadwal_id'        =>  'Jadwal Praktikum',
            'sesi_id'     =>  'Sesi Praktikum',
        ];
        $this->validate($request, [
            'jadwal_id'            =>'required',
            'sesi_id'         =>'required',
        ],$attributes);
        $matkul = MataKuliah::where('id',$matkul_id)->first();
        $sesi = SesiPraktikum::where('id',$request->sesi_id)->first();
        $terdaftar = $terdaftar = PesertaPraktikum::join('sesi_praktikums','sesi_praktikums.id','peserta_praktikums.sesi_praktikum_id')
                                ->join('jadwal_praktikums','jadwal_praktikums.id','sesi_praktikums.jadwal_praktikum_id')
                                ->join('mata_kuliahs','mata_kuliahs.id','jadwal_praktikums.mata_kuliah_id')
                                ->where('mata_kuliahs.id',$matkul_id)->where('npm',Session::get('username'))->first();
        return view('mahasiswa/matkul_detail',[
            'matkul' => $matkul,
            'sesi' => $sesi,
            'terdaftar' => $terdaftar,
        ]);

    }

    public function daftar(Request $request,$sesi_id,$matkul_id){
        $terdaftar = PesertaPraktikum::join('sesi_praktikums','sesi_praktikums.id','peserta_praktikums.sesi_praktikum_id')
                    ->join('jadwal_praktikums','jadwal_praktikums.id','sesi_praktikums.jadwal_praktikum_id')
                    ->join('mata_kuliahs','mata_kuliahs.id','jadwal_praktikums.mata_kuliah_id')
                    ->where('mata_kuliahs.id',$matkul_id)->where('npm',Session::get('username'))->first();
        if ($terdaftar) {
            $notification = array(
                'message' => 'Gagal, anda tidak dapat mendaftar 2 kali!',
                'alert-type' => 'errror'
            );
            return redirect()->back()->with($notification);
        }
        PesertaPraktikum::create([
            'sesi_praktikum_id' => $sesi_id,
            'nama_lengkap'      =>  Session::get('nama_lengkap'),
            'npm'      =>  Session::get('username'),
            'prodi'      =>  Session::get('prodi'),
        ]);

        $notification = array(
            'message' => ' anda berhasil mendaftar praktikum!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
