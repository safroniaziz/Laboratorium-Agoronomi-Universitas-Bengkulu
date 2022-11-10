@extends('layouts.app')
@section('location','Dashboard')
@section('location2')
    <i class="fa fa-home"></i>&nbsp;DASHBOARD
@endsection
@section('user-login')
    @if (Auth::check())
        {{ Auth::user()->nama_lengkap }}
    @endif
@endsection
@section('halaman')
    Halaman Laboran
@endsection
@section('content-title')
    Dashboard
    <small>Laboratorium Agronomi UNIB</small>
@endsection
@section('page')
    <li><a href="#"><i class="fa fa-home"></i> Laboratorium Agronomi UNIB</a></li>

@endsection
@section('sidebar-menu')
    @include('laboran/sidebar')
@endsection
@section('user')
    <!-- User Account Menu -->
    <li class="dropdown user user-menu">
        <!-- Menu Toggle Button -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <!-- The user image in the navbar-->
          <i class="fa fa-user"></i>&nbsp;
          <!-- hidden-xs hides the username on small devices so only the image appears. -->
          <span class="hidden-xs">{{ Auth::user()->full_name }} </span>
        </a>
    </li>
    <li>
        <a href="{{ route('logout') }}" class="btn btn-danger"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>&nbsp; Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
@endsection
@push('styles')
    <style>
        #chartdiv, #chartdiv2 {
            width: 100%;
            height: 350px;
        }
    </style>
    <style>
        .preloader {    position: fixed;    top: 0;    left: 0;    right: 0;    bottom: 0;    background-color: #ffffff;    z-index: 99999;    height: 100%;    width: 100%;    overflow: hidden !important;}.do-loader{    width: 200px;    height: 200px;    position: absolute;    left: 50%;    top: 50%;    margin: 0 auto;    -webkit-border-radius: 100%;       -moz-border-radius: 100%;         -o-border-radius: 100%;            border-radius: 100%;    background-image: url({{ asset('assets/images/logo.png') }});    background-size: 80% !important;    background-repeat: no-repeat;    background-position: center;    -webkit-background-size: cover;            background-size: cover;    -webkit-transform: translate(-50%,-50%);       -moz-transform: translate(-50%,-50%);        -ms-transform: translate(-50%,-50%);         -o-transform: translate(-50%,-50%);            transform: translate(-50%,-50%);}.do-loader:before {    content: "";    display: block;    position: absolute;    left: -6px;    top: -6px;    height: calc(100% + 12px);    width: calc(100% + 12px);    border-top: 1px solid #07A8D8;    border-left: 1px solid transparent;    border-bottom: 1px solid transparent;    border-right: 1px solid transparent;    border-radius: 100%;    -webkit-animation: spinning 0.750s infinite linear;       -moz-animation: spinning 0.750s infinite linear;         -o-animation: spinning 0.750s infinite linear;            animation: spinning 0.750s infinite linear;}@-webkit-keyframes spinning {   from {-webkit-transform: rotate(0deg);}   to {-webkit-transform: rotate(359deg);}}@-moz-keyframes spinning {   from {-moz-transform: rotate(0deg);}   to {-moz-transform: rotate(359deg);}}@-o-keyframes spinning {   from {-o-transform: rotate(0deg);}   to {-o-transform: rotate(359deg);}}@keyframes spinning {   from {transform: rotate(0deg);}   to {transform: rotate(359deg);}}
    </style>
@endpush
@section('content')
<div class="row">
    <div class="col-md-6 sm-6">
        <div class="box box-primary">

            <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i>&nbsp;Jumlah Pendaftar Per Sesi (Grafik Batang)</h3>
            </div>
            <div class="box-body">
                @section('charts')
                    var data = [
                        @foreach ($grafik as $data)
                            {
                                "country": "{{ $data['sesi'] }}",
                                "value": {{ $data['jumlah'] }}
                            },
                        @endforeach
                    ];
                @endsection
                <div id="chartdiv"></div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-6 sm-6">
        <div class="box box-primary">

            <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-pie-chart"></i>&nbsp;Jumlah Pendaftar Per Sesi (Grafik Lingkaran)</h3>
            </div>
            <div class="box-body">
                @section('charts2')
                    chart.data = [
                        @foreach ($grafik as $data)
                            {
                                "country": "{{ $data['sesi'] }}",
                                "litres": {{ $data['jumlah'] }}
                            },
                        @endforeach
                    ];
                @endsection
                <div id="chartdiv2"></div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Manajemen Data sesi Praktikum</h3>
                <div class="pull-right">
                    <a href="{{ route('laboran.sesi.add',[$jadwal_id]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah Data sesi Praktikum</a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Berhasil :</strong>{{ $message }}
                            </div>
                            @elseif ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Gagal :</strong>{{ $message }}
                                </div>
                                @else
                        @endif
                    </div>

                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Sesi</th>
                                <th>Tanggal Praktikum</th>
                                <th>Waktu Praktikum</th>
                                <th style="text-align: center">Jumlah Peserta</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($sesis as $sesi)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $sesi->sesi }} </td>
                                    <td> {{ \Carbon\Carbon::parse($sesi->tanggal_praktikum)->isoFormat('dddd, D MMMM Y') }} </td>
                                    <td> {{ date("H:i", strtotime($sesi->jam_mulai)).' s/d '.date("H:i", strtotime($sesi->jam_selesai)); }} WIB </td>
                                    <td style="text-align: center">
                                        <a href="{{ route('laboran.peserta',[$jadwal_id,$sesi->id]) }}" class="btn btn-success btn-sm btn-flat">
                                            {{ $sesi->pesertas->count() }}
                                        </a>
                                    </td>
                                    <td style="display:inline-block !important;">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{ route('laboran.sesi.edit',[$jadwal_id,$sesi->id]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('laboran.sesi.delete',[$jadwal_id,$sesi->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field("DELETE") }}
                                                        <a href="" onClick="return confirm('Apakah anda yakin menghapus data ini?')"/><button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i>&nbsp; Hapus</button></a>

                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        function deleteCourse(id){
            $('#modaldelete').modal('show');
            $('#id_hapus').val(id);
        }

      </script>
@endpush

@push('scripts')
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <!-- Chart code -->
    <script>
        am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chartdiv");


        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
        am5themes_Animated.new(root)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX:true
        }));

        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);


        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
        xRenderer.labels.template.setAll({
        rotation: -90,
        centerY: am5.p50,
        centerX: am5.p100,
        paddingRight: 15
        });

        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
        maxDeviation: 0.3,
        categoryField: "country",
        renderer: xRenderer,
        tooltip: am5.Tooltip.new(root, {})
        }));

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        maxDeviation: 0.3,
        renderer: am5xy.AxisRendererY.new(root, {})
        }));


        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
        name: "Series 1",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        sequencedInterpolation: true,
        categoryXField: "country",
        tooltip: am5.Tooltip.new(root, {
            labelText:"{valueY}"
        })
        }));

        series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
        series.columns.template.adapters.add("fill", function(fill, target) {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.adapters.add("stroke", function(stroke, target) {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
        });


        // Set data
        @yield('charts')
        xAxis.data.setAll(data);
        series.data.setAll(data);


        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);

        }); // end am5.ready()
    </script>


<!-- Resources -->
<script src="{{ asset('assets/offline/core.js') }}"></script>
<script src="{{ asset('assets/offline/chart.js') }}"></script>
<script src="{{ asset('assets/offline/animated.js') }}"></script>

<!-- Chart code -->
<script>
    am4core.ready(function() {
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    // Create chart instance
    var chart = am4core.create("chartdiv2", am4charts.PieChart);
    // Add data
    @yield('charts2')
    // Add and configure Series
    var pieSeries = chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "litres";
    pieSeries.dataFields.category = "country";
    pieSeries.slices.template.stroke = am4core.color("#fff");
    pieSeries.slices.template.strokeWidth = 2;
    pieSeries.slices.template.strokeOpacity = 1;
    // This creates initial animation
    pieSeries.hiddenState.properties.opacity = 1;
    pieSeries.hiddenState.properties.endAngle = -90;
    pieSeries.hiddenState.properties.startAngle = -90;
    }); // end am4core.ready()
</script>
@endpush
