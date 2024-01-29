<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('user') }}">
                <i class="bi bi-people menu-icon"></i>
                <span class="menu-title">User</span>
            </a>
        </li>
        <li class="nav-item">
            <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('barang') }}">
                <i class="bi bi-box-seam menu-icon"></i>
                <span class="menu-title">Barang</span>
            </a>
        </li>
    </ul>
</nav>
