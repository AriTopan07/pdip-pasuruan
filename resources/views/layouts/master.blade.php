<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISPEG</title>
    
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">
    
    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <b>SISPEG</b>
                                {{-- <img src="assets/images/logo/logo.svg" alt="Logo"
                                    srcset=""> --}}
                            </a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="hidden" id="toggle-dark">
                            </div>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item {{ Session::get('menu_active') == 'dashboard'? 'active': '' }} ">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-diagram-3"></i>
                                <span>Master</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="component-alert.html">Warna</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="component-alert.html">Ukuran</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ Session::get('menu_active') == 'users'? 'active': '' }}">
                            <a href="{{ route('users.index') }}" class='sidebar-link'>
                                <i class="bi bi-people"></i>
                                <span>User</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Session::get('menu_active') == 'seller'? 'active': '' }}">
                            <a href="{{ route('seller.index') }}" class='sidebar-link'>
                                <i class="bi bi-people"></i>
                                <span>Seller</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-funnel"></i>
                                <span>Konversi SKU</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-box-seam"></i>
                                <span>Penerimaan Barang</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-box-arrow-up-right"></i>
                                <span>Retur Gudang</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-cart-check"></i>
                                <span>Penjualan</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-cart-dash"></i>
                                <span>Retur Penjualan</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-boxes"></i>
                                <span>Stok Fisik</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-file-earmark-bar-graph"></i>
                                <span>Laporan</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="component-alert.html">Mutasi</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
            @yield('content')

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="https://saugi.me">Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
</body>
</html>