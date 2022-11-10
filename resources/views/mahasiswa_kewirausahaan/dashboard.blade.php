@extends('layouts.app_mahasiswa')
@section('mahasiswa_login')
    <a style="color:#3c8dbc">{{ Session::get('nama_lengkap') }}</a>
@endsection
@push('styles')
    <style>
        #chartdiv {
            width: 90%;
            height: 500px;
        }
    </style>
    <style>
        .preloader {    position: fixed;    top: 0;    left: 0;    right: 0;    bottom: 0;    background-color: #ffffff;    z-index: 99999;    height: 100%;    width: 100%;    overflow: hidden !important;}.do-loader{    width: 200px;    height: 200px;    position: absolute;    left: 50%;    top: 50%;    margin: 0 auto;    -webkit-border-radius: 100%;       -moz-border-radius: 100%;         -o-border-radius: 100%;            border-radius: 100%;    background-image: url({{ asset('assets/images/logo.png') }});    background-size: 80% !important;    background-repeat: no-repeat;    background-position: center;    -webkit-background-size: cover;            background-size: cover;    -webkit-transform: translate(-50%,-50%);       -moz-transform: translate(-50%,-50%);        -ms-transform: translate(-50%,-50%);         -o-transform: translate(-50%,-50%);            transform: translate(-50%,-50%);}.do-loader:before {    content: "";    display: block;    position: absolute;    left: -6px;    top: -6px;    height: calc(100% + 12px);    width: calc(100% + 12px);    border-top: 1px solid #07A8D8;    border-left: 1px solid transparent;    border-bottom: 1px solid transparent;    border-right: 1px solid transparent;    border-radius: 100%;    -webkit-animation: spinning 0.750s infinite linear;       -moz-animation: spinning 0.750s infinite linear;         -o-animation: spinning 0.750s infinite linear;            animation: spinning 0.750s infinite linear;}@-webkit-keyframes spinning {   from {-webkit-transform: rotate(0deg);}   to {-webkit-transform: rotate(359deg);}}@-moz-keyframes spinning {   from {-moz-transform: rotate(0deg);}   to {-moz-transform: rotate(359deg);}}@-o-keyframes spinning {   from {-o-transform: rotate(0deg);}   to {-o-transform: rotate(359deg);}}@keyframes spinning {   from {transform: rotate(0deg);}   to {transform: rotate(359deg);}}
    </style>
@endpush
@section('content')
<section class="content">
    <div class="callout callout-info">
        <h4>Selamat Datang, <b>{{ Session::get('nama_lengkap') }}</b></h4>
        <p>
            Laboratorium Budidaya Pertanian adalah aplikasi manajemen yang digunakan untuk mengakomodir kegiatan laboratorium baik praktikum ataupu peminjaman alat laboratorium, serta pencatatan barang laboratorium. Semua kegiatan laboratorium akan dijalankan secara online
            <br>
            <i><b>Catatan</b>: Untuk keamanan, silahkan keluar setelah selesai menggunakan aplikasi</i>
        </p>
    </div>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-book"></i>&nbsp;Daftar Mata Kuliah Praktikum Program Studi {{ Session::get('prodi') }}</h3>
        </div>
        <div class="box-body">
            {{-- <div class="row"> --}}
                @php
                    $numOfCols = 3;
                    $rowCount = 0;
                    $bootstrapColWidth = 12 / $numOfCols;
                @endphp
                @if (empty($matkuls))
                    <div class="alert alert-danger">
                        Mohon Maaf, Mata Kuliah Belum Ditambahkan
                    </div>
                @else
                    @foreach ($matkuls as $matkul)
                    @if ($rowCount % $numOfCols == 0)
                        <div class="row">
                    @endif
                    @php
                        $rowCount++;
                    @endphp
                    <a href="{{ route('mahasiswa_kewirausahaan.matkul_detail',[$matkul->id]) }}">
                        <div class="col-md-4 col-sm-6 col-xs-12 col-12 animate__animated animate__fadeInDown">
                            <!-- Widget: user widget style 1 -->
                            <div class="box box-widget widget-user-2">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-green">
                                    <div class="widget-user-image">
                                        <img class="img-circle" src="{{ asset('assets/images/buku.png') }}" alt="User Avatar">
                                    </div>
                                    <!-- /.widget-user-image -->
                                    <h3 class="widget-user-username">{{ $matkul->nama_mata_kuliah }}</h3>
                                    <h5 class="widget-user-desc">{{ $matkul->prodi->nama_prodi }}
                                    </h5>
                                </div>
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked">
                                    <li><a href="#"><b>Semester</b> <span class="pull-right">Semester {{ $matkul->semester }}</span></a></li>
                                    <li><a href="#"><b>Jumlah SKS Praktikum</b> <span class="pull-right">{{ $matkul->sks_praktikum }} SKS</span></a></li>
                                    <li><a href="#"><b>Jadwal Praktikum</b> <span class="pull-right">{{ $matkul->sks_praktikum }} Jadwal</span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                    </a>
                    @if ($rowCount % $numOfCols == 0)
                        </div>
                    @endif
                @endforeach
                @endif
            {{-- </div> --}}

        </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
@endsection
