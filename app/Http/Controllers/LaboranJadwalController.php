<?php

namespace App\Http\Controllers;

use App\Models\JadwalPraktikum;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboranJadwalController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        $jadwals = JadwalPraktikum::join('mata_kuliahs','mata_kuliahs.id','jadwal_praktikums.mata_kuliah_id')
                                    ->join('prodis','prodis.id','mata_kuliahs.prodi_id')
                                    ->select('jadwal_praktikums.id','tanggal_praktikum','nama_mata_kuliah','nama_prodi','jumlah_sesi')
                                    ->orderBy('prodi_id')
                                    ->orderBy('mata_kuliahs.id')
                                    ->get();
        return view('laboran/jadwal.index',[
            'jadwals' =>    $jadwals,
        ]);
    }

    public function add(){
        $matkuls = MataKuliah::all();
        return view('laboran/jadwal.add',[
            'matkuls' => $matkuls,
        ]);
    }

    public function post(Request $request){
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

        JadwalPraktikum::create([
            'mata_kuliah_id'            =>  $request->mata_kuliah_id,
            'tanggal_praktikum'         =>  $request->tanggal_praktikum,
            'jumlah_sesi'               =>  $request->jumlah_sesi,
        ]);

        $notification = array(
            'message' => 'Berhasil, data jadwal praktikum berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.jadwal')->with($notification);
    }
    public function edit($id){
        $matkuls = MataKuliah::all();
        $data = JadwalPraktikum::where('id',$id)->first();
        return view('laboran/jadwal.edit',compact('data','matkuls'));
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

        JadwalPraktikum::where('id',$id)->update([
            'mata_kuliah_id'            =>  $request->mata_kuliah_id,
            'tanggal_praktikum'         =>  $request->tanggal_praktikum,
            'jumlah_sesi'               =>  $request->jumlah_sesi,
        ]);

        $notification = array(
            'message' => 'Berhasil, data jadwal praktikum berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.jadwal')->with($notification);
    }
    public function delete($id){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        JadwalPraktikum::where('id',$id)->delete();
        $notification = array(
            'message' => ' data jadwal praktikum berhasil dihapus!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.jadwal')->with($notification);
    }
}
