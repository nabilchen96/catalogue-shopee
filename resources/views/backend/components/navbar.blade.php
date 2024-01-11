<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if (Auth::user()->role == 'Admin')            
            <li class="nav-item">
                <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('user') }}">
                    <i class="bi bi-people menu-icon"></i>
                    <span class="menu-title">User</span>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('agenda') }}">
                <i class="bi bi-calendar3 menu-icon"></i>
                <span class="menu-title">Agenda</span>
            </a>
        </li>
        @if (Auth::user()->role == 'Sekretariat' || Auth::user()->role == 'Admin')            
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#mr" aria-expanded="false" aria-controls="ui-basic">
                    <i class="bi bi-file-earmark-text menu-icon"></i>
                    <span class="menu-title" style="margin-top: 7px;">Sekretariat</span>
                    <i style="margin-top: 7px;" class="menu-arrow"></i>
                </a>
                <div class="collapse" id="mr">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('anggota') }}">
                                <span class="menu-title">Anggota</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('surat-masuk') }}">
                                <span class="menu-title">Surat Masuk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('surat-keluar') }}">
                                <span class="menu-title">Surat Keluar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('inventaris') }}">
                                <span class="menu-title">Inventaris</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        @if (Auth::user()->role == 'Ekonomi' || Auth::user()->role == 'Admin')            
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#eko" aria-expanded="false" aria-controls="ui-basic">
                    <i class="bi bi-cash-coin menu-icon"></i>
                    <span class="menu-title" style="margin-top: 7px;">Ekonomi</span>
                    <i style="margin-top: 7px;" class="menu-arrow"></i>
                </a>
                <div class="collapse" id="eko">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('barang') }}">
                                <span class="menu-title">Barang</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('pembelian') }}">
                                <span class="menu-title">Pembelian</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('penjualan') }}">
                                <span class="menu-title">Penjualan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('cicilan') }}">
                                <span class="menu-title">Cicilan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="showLoadingIndicator()" onclick="showLoadingIndicator()" class="nav-link" href="{{ url('stok') }}">
                                <span class="menu-title">Lap. Stok</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('absensi') }}">
                <i class="bi bi-geo-alt menu-icon"></i>
                <span class="menu-title">Absensi</span>
            </a>
        </li>
        <li class="nav-item">
            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('jurnal-umum') }}">
                <i class="bi bi-wallet2 menu-icon"></i>
                <span class="menu-title">Lap. Keuangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('notulen-rapat') }}">
                <i class="bi bi-justify-right menu-icon"></i>
                <span class="menu-title">Notulen Rapat</span>
            </a>
        </li>
        <li class="nav-item">
            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('foto-kegiatan') }}">
                <i class="bi bi-camera menu-icon"></i>
                <span class="menu-title">Foto Kegiatan</span>
            </a>
        </li>
    </ul>
</nav>
