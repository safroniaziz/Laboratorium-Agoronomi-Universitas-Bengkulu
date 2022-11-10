<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboranProdiController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        $prodis = Prodi::all();
        return view('laboran/prodi.index',[
            'prodis' =>    $prodis,
        ]);
    }

    public function add(){
        return view('laboran/prodi.add');
    }

    public function post(Request $request){
        $attributes = [
            'nama_prodi'   =>  'Pertanyaan',
            'kode_prodi'   =>  'Pertanyaan',
        ];
        $this->validate($request, [
            'nama_prodi'    =>'required',
            'kode_prodi'    =>'required',
        ],$attributes);

        Prodi::create([
            'nama_prodi'              =>  $request->nama_prodi,
            'kode_prodi'              =>  $request->kode_prodi,
        ]);

        $notification = array(
            'message' => 'Berhasil, data program studi berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.prodi')->with($notification);
    }
    public function edit($id){
        $data = Prodi::where('id',$id)->first();
        return view('laboran/prodi.edit',compact('data'));
    }
    public function update(Request $request, $id){
        $attributes = [
            'nama_prodi'   =>  'Pertanyaan',
            'kode_prodi'   =>  'Pertanyaan',
        ];
        $this->validate($request, [
            'nama_prodi'    =>'required',
            'kode_prodi'    =>'required',
        ],$attributes);

        Prodi::where('id',$id)->update([
            'nama_prodi'              =>  $request->nama_prodi,
            'kode_prodi'              =>  $request->kode_prodi,
        ]);

        $notification = array(
            'message' => 'Berhasil, data prodi berhasil diubah!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.prodi')->with($notification);
    }
    public function delete($id){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Prodi::where('id',$id)->delete();
        $notification = array(
            'message' => ' data program studi berhasil dihapus!',
            'alert-type' => 'success'
        );
        return redirect()->route('laboran.prodi')->with($notification);
    }
}
