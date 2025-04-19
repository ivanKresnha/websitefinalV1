{{-- NAVBAR START --}}
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('assets_landingpage/asset_tambahan/logo/logo_landingpage.png') }}" alt="logo" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse main-menu-item justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#home">HOME</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#rekomendasi">REKOMENDASI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tentang_kami">TENTANG KAMI</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#home" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    LAINNYA
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#owner_developer">OWNER & DEVELOPER</a>
                    <a class="dropdown-item" href="#produk">PRODUK</a>
                    <a class="dropdown-item" href="#kontak_kami">KONTAK & LOKASI</a>
                    <a class="dropdown-item" href="#testimoni">TESTIMONI</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="login_btn">
        <a href="{{ route('login') }}" class="single_page_btn d-none d-sm-block">
            Login
        </a>
    </div>

    <!-- Navbar for Logged In Users (Customer) -->
    @auth
        @if (Auth::user()->role_id == 2)
            <!-- Check if user is a customer -->
            <!-- Toggle Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse main-menu-item justify-content-between" id="navbarSupportedContent">
                <!-- Left Menu -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/produk/index.html">PRODUK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/transaksi/index.html">TRANSAKSI SAYA</a>
                    </li>
                </ul>

                <!-- Search Form -->
                <div class="d-flex justify-content-center align-items-center gap-3 w-100" id="searchWrapper">
                    <form class="d-flex align-items-center flex-grow-1" id="searchForm">
                        <input class="form-control" type="search" placeholder="Cari produk atau pesanan"
                            aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>

                </div>
            </div>
        @endif
    @endauth
</nav>
{{-- NAVBAR END --}}
