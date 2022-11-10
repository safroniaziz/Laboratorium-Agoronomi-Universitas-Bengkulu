<li class="header" style="font-weight:bold;">MENU UTAMA</li>
<li class="{{ set_active('laboran.dashboard') }}">
    <a href="{{ route('laboran.dashboard') }}">
        <i class="fa fa-home"></i> <span>Dashboard</span>
    </a>
</li>

<li class="{{ set_active(['laboran.prodi','laboran.prodi.add','laboran_prodi.edit']) }}">
    <a href="{{ route('laboran.prodi') }}">
        <i class="fa fa-building-o"></i> <span>Program Studi</span>
    </a>
</li>

<li class="{{ set_active(['laboran.matkul','laboran.matkul.add','laboran.matkul.edit']) }}">
    <a href="{{ route('laboran.matkul') }}">
        <i class="fa fa-book"></i> <span>Mata Kuliah</span>
    </a>
</li>

<li class="{{ set_active(['laboran.jadwal','laboran.jadwal.add','laboran.jadwal.edit','laboran.sesi','laboran.sesi.add','laboran.sesi.edit','laboran.peserta']) }}">
    <a href="{{ route('laboran.jadwal') }}">
        <i class="fa fa-clock-o"></i> <span>Jadwal Praktikum</span>
    </a>
</li>

<li style="padding-left:2px;">
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off text-danger"></i>{{__('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</li>
