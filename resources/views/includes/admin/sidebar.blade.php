{{-- Start Sidebar --}}
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Menu for Admin --}}
                @can('akses_dashboard')
                    {{-- Kelola User --}}
                    @can('akses_kelola_user')
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#kelolaUser" aria-expanded="false">
                                <i class="fas fa-users"></i>
                                <p>Kelola User</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="kelolaUser">
                                <ul class="nav nav-collapse">
                                    @can('akses_data_pengguna')
                                        <li><a href="{{ route('dashboard.users.index') }}"><span class="sub-item">Kelola Data
                                                    User</span></a></li>
                                    @endcan
                                    @can('akses_data_peran_pengguna')
                                        <li><a href="{{ route('dashboard.roles.index') }}"><span class="sub-item">Kelola Data Peran
                                                    User</span></a></li>
                                    @endcan
                                    @can('akses_data_akses_pengguna')
                                        <li><a href="{{ route('dashboard.permissions.index') }}"><span class="sub-item">Data Akses
                                                    User</span></a></li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan

                    {{-- Kelola Data --}}
                    @can('akses_kelola_data')
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#kelolaData" aria-expanded="false">
                                <i class="fas fa-database"></i>
                                <p>Kelola Data</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="kelolaData">
                                <ul class="nav nav-collapse">
                                    @can('akses_kelola_kategori_produk')
                                        <li><a href="{{ route('dashboard.categories.index') }}"><span class="sub-item">Data
                                                    Kategori Produk</span></a></li>
                                    @endcan
                                    @can('akses_kelola_produk')
                                        <li><a href="{{ route('dashboard.products.index') }}"><span class="sub-item">Data
                                                    Produk</span></a></li>
                                    @endcan
                                    @can('akses_kelola_transaksi')
                                        <li><a href="{{ route('dashboard.transactions.index') }}"><span class="sub-item">Data
                                                    Transaksi</span></a></li>
                                    @endcan
                                    @can('akses_kelola_laporan_transaksi')
                                        <li><a href="{{ route('dashboard.laporan_transaksi.index') }}"><span class="sub-item">Data
                                                    Laporan Transaksi</span></a></li>
                                    @endcan
                                    @can('akses_kelola_ulasan')
                                        <li><a href="{{ route('dashboard.reviews.index') }}"><span class="sub-item">Data Ulasan
                                                    Produk</span></a></li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                @endcan

                {{-- Log Aktivitas (Item Menu Baru) --}}
                @can('akses_log_aktivitas')
                    <li class="nav-item">
                        <a href="{{ route('dashboard.activityLogs.index') }}">
                            <i class="fas fa-history"></i>
                            <p>Log Aktivitas</p>
                        </a>
                    </li>
                @endcan



            </ul>
        </div>
    </div>
</div>
{{-- End Sidebar --}}

<!-- Main Panel -->
<div class="main-panel">
    <div class="main-header">
        <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a href="{{ url('index.html') }}" class="logo">
                    <img src="{{ asset('assets_admin/logo/logo_light.svg') }}" alt="navbar brand"
                        class="navbar-brand" height="40" />
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
        </div>

        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
                <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-search pe-1">
                                <i class="fa fa-search search-icon"></i>
                            </button>
                        </div>
                        <input type="text" placeholder="Search ..." class="form-control" />
                    </div>
                </nav>

                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                    <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false" aria-haspopup="true">
                            <i class="fa fa-search"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-search animated fadeIn">
                            <form class="navbar-left navbar-form nav-search">
                                <div class="input-group">
                                    <input type="text" placeholder="Search ..." class="form-control" />
                                </div>
                            </form>
                        </ul>
                    </li>

                    <li class="nav-item topbar-user dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                            aria-expanded="false">
                            <div class="avatar-sm">
                                <img src="{{ asset('storage/uploads/user/' . (Auth::user()->gambar_profil ?? 'profile.jpg')) }}" alt="..."
                                    class="avatar-img rounded-circle" />
                            </div>
                            <span class="profile-username">
                                <span class="op-7">Hi,</span>
                                <span class="fw-bold">{{ Auth::user()->name }}</h4> <!-- Nama user -->
                                </span>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg">
                                            <!-- Periksa apakah pengguna memiliki gambar profil yang di-upload -->
                                            <img src="{{ asset('storage/uploads/user/' . (Auth::user()->gambar_profil ?? 'profile.jpg')) }}"
                                                alt="image profile" class="avatar-img rounded-circle" />
                                        </div>


                                        <div class="u-text">
                                            <h4>{{ Auth::user()->name }}</h4>
                                            <p class="text-muted">{{ Auth::user()->email }}</p> <!-- Email user -->
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
    </div>
