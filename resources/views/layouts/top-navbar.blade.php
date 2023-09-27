<ul id="nav_menu">
    <li>
        <a href="/"><i class="ti-dashboard"></i><span>Dashboard</span></a>
    </li>
    <li>
        <a href="javascript:void(0)"><i class="fas fa-toolbox"></i><span>Master Data</span></a>
        <ul class="submenu">
            <li><a href="{{ route('alat.index') }}">Data Alat</a></li>
            <li><a href="{{ route('brand.index') }}">Data Brand</a></li>
            <li><a href="{{ route('garansi.index') }}">Data Garansi</a></li>
            <li><a href="{{ route('rumahsakit.index') }}">Daftar Rumah Sakit</a></li>
            <li><a href="{{ route('faqs.index') }}">Faq's</a></li>
            <li><a href="{{ route('manual-book.index') }}">Manual Books</a></li>
        </ul>
    </li>
    <li>
        <a href="javascript:void(0)"><i class="fas fa-database"></i><span>Kelola Data</span></a>
        <ul class="submenu">
            <li><a href="{{ route('data-alat-terpasang.index') }}">Data Alat Terpasang</a></li>
        </ul>
    </li>
    <li>
        <a href="javascript:void(0)"><i class="fas fa-tools"></i><span>Servis</span></a>
        <ul class="submenu">
            <li><a href="{{ route('pemasangan-alat.index') }}">Buat Data Pemasangan Alat</a></li>
            <li><a href="">Daftar Kontrak</a></li>
            <li><a href="">Buat Form Servis</a></li>
        </ul>
    </li>
</ul>
