<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laboratorium Agronomi UNIB</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/login/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <style>
        .preloader {    position: fixed;    top: 0;    left: 0;    right: 0;    bottom: 0;    background-color: #ffffff;    z-index: 99999;    height: 100%;    width: 100%;    overflow: hidden !important;}.do-loader{    width: 200px;    height: 200px;    position: absolute;    left: 50%;    top: 50%;    margin: 0 auto;    -webkit-border-radius: 100%;       -moz-border-radius: 100%;         -o-border-radius: 100%;            border-radius: 100%;    background-image: url({{ asset('assets/images/logo.png') }});    background-size: 80% !important;    background-repeat: no-repeat;    background-position: center;    -webkit-background-size: cover;            background-size: cover;    -webkit-transform: translate(-50%,-50%);       -moz-transform: translate(-50%,-50%);        -ms-transform: translate(-50%,-50%);         -o-transform: translate(-50%,-50%);            transform: translate(-50%,-50%);}.do-loader:before {    content: "";    display: block;    position: absolute;    left: -6px;    top: -6px;    height: calc(100% + 12px);    width: calc(100% + 12px);    border-top: 1px solid #07A8D8;    border-left: 1px solid transparent;    border-bottom: 1px solid transparent;    border-right: 1px solid transparent;    border-radius: 100%;    -webkit-animation: spinning 0.750s infinite linear;       -moz-animation: spinning 0.750s infinite linear;         -o-animation: spinning 0.750s infinite linear;            animation: spinning 0.750s infinite linear;}@-webkit-keyframes spinning {   from {-webkit-transform: rotate(0deg);}   to {-webkit-transform: rotate(359deg);}}@-moz-keyframes spinning {   from {-moz-transform: rotate(0deg);}   to {-moz-transform: rotate(359deg);}}@-o-keyframes spinning {   from {-o-transform: rotate(0deg);}   to {-o-transform: rotate(359deg);}}@keyframes spinning {   from {transform: rotate(0deg);}   to {transform: rotate(359deg);}}
    </style>
</head>

<body>
    <div class="preloader">
        <div class="do-loader"></div>
    </div>
    <div class="d-flex align-items-center " style="height: 100vh">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 p-5 p-md-0">
                    <img src="{{ asset('assets/images/logo.png') }}" height="100">
                    <div class="mb-4">
                        <h2 style="color:white">Daftar Praktikum Kewirausahaan <br> Masukan Username dan Password Portal Akademik</h2>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            {{ $message }}
                        </div>
                        @elseif ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                {{ $message }}
                            </div>
                    @endif
                    <form method="POST" action="{{ route('login_kewirausahaan_post') }}">
                        @csrf
                        <div class="form-group">
                            <label for="npm" style="color:white">Nomor Pokok Mahasiswa</label>
                            <input type="text" name="username" class="form-control @error('npm') is-invalid @enderror"
                                id="npm" placeholder="npm" value="{{ old('npm') }}" autocomplete="npm"
                                autofocus />
                            <div>
                                @if ($errors->has('email'))
                                    <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" style="color:white">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="password"
                                placeholder="password" autocomplete="current-password" />
                            <div>
                                @if ($errors->has('password'))
                                    <small class="form-text text-danger">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('login_mahasiswa') }}" class="text-white"><i class="fa fa-arrow-right"></i>&nbsp;Daftar Praktikum Agronomi</a>
                        <br>
                        <button type="submit" class="btn btn-primary mt-2">
                            <i class="fa fa-sign-in"></i>&nbsp;Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $(window).on('load', function(){
            // will first fade out the loading animation
            jQuery(".status").fadeOut();
            // will fade out the whole DIV that covers the website.
            jQuery(".preloader").delay(0).fadeOut("slow");
        });
    </script>
</body>

</html>

