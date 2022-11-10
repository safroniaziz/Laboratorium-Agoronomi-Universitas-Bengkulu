<?php

namespace App\Http\Controllers;

use App\Models\JadwalPraktikum;
use App\Models\MataKuliah;
use App\Models\PesertaPraktikum;
use App\Models\SesiPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboranSesiController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($jadwal_id){
        $grafik = PesertaPraktikum::join('sesi_praktikums','sesi_praktikums.id','peserta_praktikums.sesi_praktikum_id')
                                    ->select('sesi',DB::raw('count(peserta_praktikums.id) as jumlah'))
                                    ->groupBy('sesi_praktikums.id')
                                    ->where('jadwal_praktikum_id',$jadwal_id)
                                    ->get();
        $sesis = SesiPraktikum::join('jadwal_praktikums','jadwal_praktikums.id','sesi_praktikums.jadwal_praktikum_id')
                                    ->select('sesi_praktikums.id','sesi','tanggal_praktikum','jumlah_peserta','jam_mulai','jam_selesai')
                                    ->where('jadwal_praktikum_id',$jadwal_id)
                                    ->get();
        return view('laboran/sesi.index',[
            'sesis' =>    $sesis,
            'jadwal_id' =>  $jadwal_id,
            'grafik'    => $grafik,
        ]);
    }

    public function add($jadwal_id){
        $jadwal = JadwalPraktikum::where('id',$jadwal_id)->first();
        return view('laboran/sesi.add',[
            'jadwal' => $jadwal,
        ]);
    }

    public function post(Request $request, $jadwal_id){
        $attributes = [
            'sesi'              =>  'Nama Sesi',
            'jumlah_peserta'    =>  'Jumlah Peserta',
            'jam_mulai_'        =>  'Jam Mulai',
            'jam_selesai'       =>  'Jam Selesai',
        ];
        $this->validate($request, [
            'sesi'              =>'required',
            'jumlah_peserta'    =>'required',
            'jam_mulai'         =>'required',
            'jam_selesai'       =>'required',
        ],$attributes);

        SesiPraktikum::create([
            'jadwal_praktikum_id'   =>  $jadwal_id,
            'jumlah_peserta'        =>  $request->jumlah_peserta,
            'sesi'                  =>  $request->sesi,
            'jam_mulai'             =>  $request->jam_mulai,
            'jam_selesai'           =>  $request->jam_selesai,
        ]);

        $notification = array(
            'message' => 'Berhasil, data sesi praktikum berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.sesi',[$jadwal_id])->with($notification);
    }
    public function edit($id){
        $matkuls = MataKuliah::all();
        $data = SesiPraktikum::where('id',$id)->first();
        return view('laboran/sesi.edit',compact('data','matkuls'));
    }
    public function update(Request $request, $id){
        $attributes = [
            'mata_kuliah_id'        =>  'Nama unit',
            'tanggal_praktikum'     =>  'Tanggal Praktikum',
            'jumlah_sesi'           =>  'Jumlah Sesi',
        ];
        $this->validate($request, [
            'mata_kuliah_id'            =>'required',
            'tanggal_praktikum'         =>'required',
            'jumlah_sesi'               =>'required',
        ],$attributes);

        SesiPraktikum::where('id',$id)->update([
            'mata_kuliah_id'            =>  $request->mata_kuliah_id,
            'tanggal_praktikum'         =>  $request->tanggal_praktikum,
            'jumlah_sesi'               =>  $request->jumlah_sesi,
        ]);

        $notification = array(
            'message' => 'Berhasil, data sesi praktikum berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.sesi')->with($notification);
    }
    public function delete($id){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SesiPraktikum::where('id',$id)->delete();
        $notification = array(
            'message' => ' data sesi praktikum berhasil dihapus!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.sesi')->with($notification);
    }

    public function peserta($jadwal_id, $sesi_id){
        $jadwal = SesiPraktikum::findOrFail($sesi_id);
        $pesertas = PesertaPraktikum::join('sesi_praktikums','sesi_praktikums.id','peserta_praktikums.sesi_praktikum_id')
                                    ->join('jadwal_praktikums','jadwal_praktikums.id','sesi_praktikums.jadwal_praktikum_id')
                                    ->select('peserta_praktikums.id','sesi','tanggal_praktikum','nama_lengkap','jam_mulai','jam_selesai','npm','prodi','peserta_praktikums.created_at')
                                    ->where('sesi_praktikum_id',$sesi_id)
                                    ->get();
        return view('laboran/sesi.peserta',[
            'pesertas' => $pesertas,
            'jadwal' => $jadwal,
        ]);
    }
}
