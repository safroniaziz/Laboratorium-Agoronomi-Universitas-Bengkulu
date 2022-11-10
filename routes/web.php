<?php

use App\Http\Controllers\LaboranDashboardController;
use App\Http\Controllers\LaboranJadwalController;
use App\Http\Controllers\LaboranMatkulController;
use App\Http\Controllers\LaboranProdiController;
use App\Http\Controllers\LaboranSesiController;
use App\Http\Controllers\MahasiswaDashboardController;
use App\Http\Controllers\MahasiswaKewirausahaanDashboardController;
use App\Http\Controllers\PandaController;
use App\Http\Controllers\PandaKewirausahaanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login_mahasiswa');
})->name('login_mahasiswa');

Route::get('/daftar_praktikum_kewirausahaan', function () {
    return view('auth.login_kewirausahaan');
})->name('login_kewirausahaan');

Route::post('/pandalogin',[PandaController::class, 'pandaLogin'])->name('login_mahasiswa_post');
Route::get('/logout', [PandaController::class, 'authLogout'])->name('logout_mahasiswa');

Route::post('/pandalogin_kewirausahaan',[PandaKewirausahaanController::class, 'pandaKewirausahaanLogin'])->name('login_kewirausahaan_post');
Route::get('/logout_kewirausahaan', [PandaKewirausahaanController::class, 'authKewirausahaanLogout'])->name('logout_kewirausahaan');

Route::group(['prefix'  => 'mahasiswa'],function(){
    Route::get('/',[MahasiswaDashboardController::class,'dashboard'])->name('mahasiswa.dashboard');
    Route::get('/{matkul_id}/matkul_detail',[MahasiswaDashboardController::class,'matkulDetail'])->name('mahasiswa.matkul_detail');
    Route::get('/cari_sesi',[MahasiswaDashboardController::class,'cariSesi'])->name('mahasiswa.cari_sesi');
    Route::get('/{matkul_id}/cari_sesi',[MahasiswaDashboardController::class,'cariDetail'])->name('mahasiswa.cari_detail');
    Route::post('{sesi_id}/{matkul_id}/matkul_detail',[MahasiswaDashboardController::class,'daftar'])->name('mahasiswa.daftar');
});

Route::group(['prefix'  => 'mahasiswa_kewirausahaan'],function(){
    Route::get('/',[MahasiswaKewirausahaanDashboardController::class,'dashboard'])->name('mahasiswa_kewirausahaan.dashboard');
    Route::get('/{matkul_id}/matkul_detail',[MahasiswaKewirausahaanDashboardController::class,'matkulDetail'])->name('mahasiswa_kewirausahaan.matkul_detail');
    Route::get('/cari_sesi',[MahasiswaKewirausahaanDashboardController::class,'cariSesi'])->name('mahasiswa_kewirausahaan.cari_sesi');
    Route::get('/{matkul_id}/cari_sesi',[MahasiswaKewirausahaanDashboardController::class,'cariDetail'])->name('mahasiswa_kewirausahaan.cari_detail');
    Route::post('{sesi_id}/{matkul_id}/matkul_detail',[MahasiswaKewirausahaanDashboardController::class,'daftar'])->name('mahasiswa_kewirausahaan.daftar');
});

Route::group(['prefix'  => 'laboran'],function(){
    Auth::routes();
    Route::get('/',[LaboranDashboardController::class,'dashboard'])->name('laboran.dashboard');
    Route::group(['prefix'  => 'mata_kuliah'],function(){
        Route::get('/',[LaboranMatkulController::class,'index'])->name('laboran.matkul');
        Route::get('/tambah',[LaboranMatkulController::class, 'add'])->name('laboran.matkul.add');
        Route::post('/post',[LaboranMatkulController::class, 'post'])->name('laboran.matkul.post');
        Route::get('/{id}/edit',[LaboranMatkulController::class, 'edit'])->name('laboran.matkul.edit');
        Route::patch('/{id}/update',[LaboranMatkulController::class, 'update'])->name('laboran.matkul.update');
        Route::delete('{id}/delete',[LaboranMatkulController::class, 'delete'])->name('laboran.matkul.delete');
    });

    Route::group(['prefix'  => 'program_studi'],function(){
        Route::get('/',[LaboranProdiController::class,'index'])->name('laboran.prodi');
        Route::get('/tambah',[LaboranProdiController::class, 'add'])->name('laboran.prodi.add');
        Route::post('/post',[LaboranProdiController::class, 'post'])->name('laboran.prodi.post');
        Route::get('/{id}/edit',[LaboranProdiController::class, 'edit'])->name('laboran.prodi.edit');
        Route::patch('/{id}/update',[LaboranProdiController::class, 'update'])->name('laboran.prodi.update');
        Route::delete('{id}/delete',[LaboranProdiController::class, 'delete'])->name('laboran.prodi.delete');
    });

    Route::group(['prefix'  => 'jadwal_praktikum'],function(){
        Route::get('/',[LaboranJadwalController::class,'index'])->name('laboran.jadwal');
        Route::get('/tambah',[LaboranJadwalController::class, 'add'])->name('laboran.jadwal.add');
        Route::post('/post',[LaboranJadwalController::class, 'post'])->name('laboran.jadwal.post');
        Route::get('/{id}/edit',[LaboranJadwalController::class, 'edit'])->name('laboran.jadwal.edit');
        Route::patch('/{id}/update',[LaboranJadwalController::class, 'update'])->name('laboran.jadwal.update');
        Route::delete('{id}/delete',[LaboranJadwalController::class, 'delete'])->name('laboran.jadwal.delete');

        Route::group(['prefix'  => '/sesi_praktikum'],function(){
            Route::get('/{jadwal_id}/',[LaboranSesiController::class,'index'])->name('laboran.sesi');
            Route::get('/{jadwal_id}/tambah',[LaboranSesiController::class, 'add'])->name('laboran.sesi.add');
            Route::post('/{jadwal_id}/post',[LaboranSesiController::class, 'post'])->name('laboran.sesi.post');
            Route::get('/{jadwal_id}/edit/{id}',[LaboranSesiController::class, 'edit'])->name('laboran.sesi.edit');
            Route::patch('/{jadwal_id}/update/{id}',[LaboranSesiController::class, 'update'])->name('laboran.sesi.update');
            Route::delete('/{jadwal_id}/delete/{id}',[LaboranSesiController::class, 'delete'])->name('laboran.sesi.delete');

            Route::group(['prefix'  => '{jadwal_id}/peserta'],function(){
                Route::get('/{sesi_id}/',[LaboranSesiController::class,'peserta'])->name('laboran.peserta');
            });
        });
    });
});
