<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboranMatkulController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        $matkuls = MataKuliah::all();
        return view('laboran/matkul.index',[
            'matkuls' =>    $matkuls,
        ]);
    }

    public function add(){
        $prodis = Prodi::all();
        return view('laboran/matkul.add',[
            'prodis' => $prodis,
        ]);
    }

    public function post(Request $request){
        $attributes = [
            'nama_mata_kuliah'  =>  'Nama Mata Kuliah',
            'kode_matkul'  =>  'Kode Mata Kuliah',
            'prodi_id'          =>  'Nama Program Studi',
            'semester'          =>  'Semester',
            'sks_praktikum'               =>  'Jumlah SKS',
        ];
        $this->validate($request, [
            'nama_mata_kuliah'  =>'required',
            'kode_matkul'  =>'required',
            'prodi_id'          =>'required',
            'semester'          =>'required',
            'sks_praktikum'               =>'required',
        ],$attributes);

        MataKuliah::create([
            'nama_mata_kuliah'  =>  $request->nama_mata_kuliah,
            'kode_matkul'  =>  $request->kode_matkul,
            'prodi_id'          =>  $request->prodi_id,
            'semester'          =>  $request->semester,
            'sks_praktikum'               =>  $request->sks_praktikum,
        ]);

        $notification = array(
            'message' => 'Berhasil, data mata kuliah berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.matkul')->with($notification);
    }
    public function edit($id){
        $prodis = Prodi::all();
        $data = MataKuliah::where('id',$id)->first();
        return view('laboran/matkul.edit',compact('data','prodis'));
    }
    public function update(Request $request, $id){
        $attributes = [
            'nama_mata_kuliah'  =>  'Nama Mata Kuliah',
            'kode_matkul'  =>  'Kode Mata Kuliah',
            'prodi_id'          =>  'Nama Program Studi',
            'semester'          =>  'Semester',
            'sks_praktikum'               =>  'Jumlah SKS',
        ];
        $this->validate($request, [
            'nama_mata_kuliah'  =>'required',
            'kode_matkul'  =>'required',
            'prodi_id'          =>'required',
            'semester'          =>'required',
            'sks_praktikum'               =>'required',
        ],$attributes);

        MataKuliah::where('id',$id)->update([
            'nama_mata_kuliah'  =>  $request->nama_mata_kuliah,
            'kode_matkul'  =>  $request->kode_matkul,
            'prodi_id'          =>  $request->prodi_id,
            'semester'          =>  $request->semester,
            'sks_praktikum'               =>  $request->sks_praktikum,
        ]);

        $notification = array(
            'message' => 'Berhasil, data mata kuliah berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.matkul')->with($notification);
    }
    public function delete($id){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MataKuliah::where('id',$id)->delete();
        $notification = array(
            'message' => ' data Mata Kuliah berhasil dihapus!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.matkul')->with($notification);
    }
}
