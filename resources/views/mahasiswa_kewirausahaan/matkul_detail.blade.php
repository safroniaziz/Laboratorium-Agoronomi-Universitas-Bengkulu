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
        .loading-icon {
  position: relative;
  width: 20px;
  height: 20px;
  margin:50px auto;
  -webkit-animation: fa-spin 2s infinite linear;
  animation: fa-spin 2s infinite linear;
}

.loading-icon:before {
  content: "\f110";
  font-family: FontAwesome;
  font-size:20px;
  position: absolute;
  top: 0;
}
    </style>
    <style>
        .preloader {    position: fixed;    top: 0;    left: 0;    right: 0;    bottom: 0;    background-color: #ffffff;    z-index: 99999;    height: 100%;    width: 100%;    overflow: hidden !important;}.do-loader{    width: 200px;    height: 200px;    position: absolute;    left: 50%;    top: 50%;    margin: 0 auto;    -webkit-border-radius: 100%;       -moz-border-radius: 100%;         -o-border-radius: 100%;            border-radius: 100%;    background-image: url({{ asset('assets/images/logo.png') }});    background-size: 80% !important;    background-repeat: no-repeat;    background-position: center;    -webkit-background-size: cover;            background-size: cover;    -webkit-transform: translate(-50%,-50%);       -moz-transform: translate(-50%,-50%);        -ms-transform: translate(-50%,-50%);         -o-transform: translate(-50%,-50%);            transform: translate(-50%,-50%);}.do-loader:before {    content: "";    display: block;    position: absolute;    left: -6px;    top: -6px;    height: calc(100% + 12px);    width: calc(100% + 12px);    border-top: 1px solid #07A8D8;    border-left: 1px solid transparent;    border-bottom: 1px solid transparent;    border-right: 1px solid transparent;    border-radius: 100%;    -webkit-animation: spinning 0.750s infinite linear;       -moz-animation: spinning 0.750s infinite linear;         -o-animation: spinning 0.750s infinite linear;            animation: spinning 0.750s infinite linear;}@-webkit-keyframes spinning {   from {-webkit-transform: rotate(0deg);}   to {-webkit-transform: rotate(359deg);}}@-moz-keyframes spinning {   from {-moz-transform: rotate(0deg);}   to {-moz-transform: rotate(359deg);}}@-o-keyframes spinning {   from {-o-transform: rotate(0deg);}   to {-o-transform: rotate(359deg);}}@keyframes spinning {   from {transform: rotate(0deg);}   to {transform: rotate(359deg);}}
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css">
@endpush
@section('content')
<section class="content">
            <div class="row">
                <div class="col-md-4">

                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;Jadwal dan Sesi Praktikum</h3>

                      <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                        <div class="row" style="margin-bottom:10px !important;">
                            <div class="col-md-12" style="margin-bottom:10px !important;">
                                <a href="{{ route('mahasiswa_kewirausahaan.dashboard') }}" class="btn btn-warning btn-sm btn-flat" name="submit"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-danger"><i class="fa fa-info-circle"></i>&nbsp;Harap pilih jadwal praktikum terlebih dahulu</div>
                            </div>
                            <form action="{{ route('mahasiswa_kewirausahaan.cari_detail',[$matkul->id]) }}" method="GET">
                                {{ csrf_field() }} {{ method_field('GET') }}
                                <div class="form-group col-md-12">
                                    <label>Pilih Jadwal Praktikum</label>
                                    <select name="jadwal_id" id="jadwal_id" class="form-control">
                                        <option disabled selected value>-- pilih jadwal --</option>
                                        @foreach ($matkul->jadwals()->get() as $item)
                                            <option value="{{ $item->id }}">{{ \Carbon\Carbon::parse($item->tanggal_praktikum)->isoFormat('dddd, D MMMM Y') }}</option>
                                        @endforeach
                                        <div>
                                            @if ($errors->has('jadwal_id'))
                                                <small class="form-text text-danger">{{ $errors->first('jadwal_id') }}</small>
                                            @endif
                                        </div>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                  <label>Pilih Sesi Praktikum</label>
                                  <select name="sesi_id" id="sesi_id" class="form-control">
                                      <option disabled selected value>-- pilih sesi --</option>
                                  </select>
                                  <div>
                                        @if ($errors->has('sesi_id'))
                                            <small class="form-text text-danger">{{ $errors->first('sesi_id') }}</small>
                                        @else
                                            <small class="text-warning" id="notif-warning" style="display: none;"><i><i class="fa fa-refresh fa-spin"></i>&nbsp;sedang mencari sesi</i></small>
                                            <small class="text-success" id="notif-success" style="display: none;"><i><i class="fa fa-check-circle"></i>&nbsp;sesi ditemukan</i></small>
                                            <small class="text-danger" id="notif-danger" style="display: none;"><i><i class="fa fa-close"></i>&nbsp;sesi tidak ditemukan</i></small>
                                        @endif
                                    </div>

                              </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check-circle"></i>&nbsp; Lihat Jadwal</button>
                                </div>
                            </form>
                        </div>
                        @if (isset($_GET['sesi_id']))
                            <div id="alert_sesi"
                                @if ($sesi->jumlah_peserta > $sesi->pesertas()->count() && empty($terdaftar))
                                    class="alert alert-success"
                                @else
                                    class="alert alert-danger"
                                @endif
                            ><i class="fa fa-info-circle"></i>&nbsp;
                                @if ($sesi->jumlah_peserta > $sesi->pesertas()->count() && empty($terdaftar))
                                   Sesi Ditemukan, masih tersedia sebanyak {{ $sesi->jumlah_peserta - $sesi->pesertas()->count() }} slot peserta
                                @else
                                    Mohon Maaf, slot peserta sudah habis atau anda sudah mendaftar praktikum mata kuliah ini, anda tidak dapat melakukan pendaftaran
                                @endif
                            </div>
                            <hr style="border: 1px solid #cac7c7">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#"><i class="fa fa-check"></i>
                                    Klik Untuk Daftar<span class="pull-right">
                                    @if ($sesi->jumlah_peserta > $sesi->pesertas()->count() && empty($terdaftar))
                                        <form action="{{ route('mahasiswa_kewirausahaan.daftar',[$sesi->id,$matkul->id]) }}" method="post">
                                            {{ csrf_field() }} {{ method_field('POST') }}
                                            <button type="submit" class="btn btn-primary btn-sm btn-flat" name="submit"><i class="fa fa-user-plus"></i>&nbsp; Daftar</button>
                                        </form>
                                    @else
                                        <button type="submit" disabled class="btn btn-primary btn-sm btn-flat" name="submit"><i class="fa fa-user-plus"></i>&nbsp; Daftar</button>
                                    @endif
                                    </span></a>
                                </li>
                                <li><a href="#"><i class="fa fa-calendar"></i>
                                    Nama Sesi<span class="pull-right">{{ $sesi->sesi }}</span></a>
                                </li>
                                <li><a href="#"><i class="fa fa-user"></i>
                                    Maksimal Peserta<span class="pull-right">{{ $sesi->jumlah_peserta }}</span></a>
                                </li>
                                <li><a href="#"><i class="fa fa-users"></i>
                                    Peserta Terdaftar<span class="pull-right">{{ $sesi->pesertas()->count() }}</span></a>
                                </li>
                                <li><a href="#"><i class="fa fa-calendar"></i>
                                    Jadwal Praktikum<span class="pull-right">{{ \Carbon\Carbon::parse($sesi->tanggal_praktikum)->isoFormat('dddd, D MMMM Y') }}</span></a>
                                </li>
                                <li><a href="#"><i class="fa fa-clock-o"></i>
                                    Jam Mulai<span class="pull-right">{{ $sesi->jam_mulai }}</span></a>
                                </li>
                                <li><a href="#"><i class="fa fa-clock-o"></i>
                                    Jam Selesai<span class="pull-right">{{ $sesi->jam_selesai }}</span></a>
                                </li>
                            </ul>
                        @endif
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /. box -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title"><i class="fa fa-users"></i>&nbsp;Data Pendaftar Praktikum</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Nomor Pokok Mahasiswa</th>
                                        <th>Program Studi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @if (isset($sesi))
                                        @forelse ($sesi->pesertas()->get() as $item)
                                            <tr>
                                                <td class="mailbox-name">{{ $no++ }}</td>
                                                <td class="mailbox-name"><a href="">{{ $item->nama_lengkap }}</a></td>
                                                <td class="mailbox-subject">{{ $item->npm }}
                                                </td>
                                                <td class="mailbox-date">{{ $item->prodi }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-danger text-bold text-center">Belum ada peserta yang mendaftar</td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-danger text-bold text-center">Silahkan pilih jadwal dan sesi praktikum terlebih dahulu</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                      <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /. box -->
                </div>
                <!-- /.col -->
            </div>
</section>
@endsection

@push('scripts')
    <script>
        $(document).on('change','#jadwal_id',function(){
            var jadwal_id = $(this).val();
            var div = $(this).parent().parent();
            $('#alert_sesi').hide();
            var op=" ";
            $('#notif-warning').show();
            $('#notif-danger').hide();
            $('#notif-success').hide();
            $.ajax({
            type :'get',
            url: "{{ url('mahasiswa/cari_sesi') }}",
            data:{'jadwal_id':jadwal_id},
                success:function(data){
                    if (data.length >0) {
                        $('#notif-warning').hide();
                        $('#notif-success').show();
                        $('#notif-danger').hide();
                    }else{
                        $('#notif-warning').hide();
                        $('#notif-danger').show();
                        $('#notif-success').hide();
                    }
                    // alert(data[i].id);
                    // alert(data['prodi'][0]['dosen'][0]['pegawai'].pegIsAktif);
                    op+='<option value="0" selected disabled>-- pilih sesi --</option>';
                    for(var i=0; i<data.length;i++){
                        var ke = 1+i;
                        op+='<option value="'+data[i].id+'">'+data[i].sesi+'</option>';
                    }
                    div.find('#sesi_id').html(" ");
                    div.find('#sesi_id').append(op);
                },
                    error:function(){

                }
            });
        });
    </script>
@endpush
