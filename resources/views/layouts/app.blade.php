<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laundry') - Aplikasi Laundry</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    
    @stack('styles')
    <style>
    #main {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .page-heading {
        flex-grow: 1;
    }
</style>
</head>
<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                                <h4 class="mb-0 d-flex align-items-center gap-2" style="color: #435ebe;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <rect x="3" y="2" width="18" height="20" rx="2" ry="2"></rect>
                                      <line x1="3" y1="6" x2="21" y2="6"></line>
                                      <circle cx="12" cy="14" r="4"></circle>
                                      <path d="M12 14c-1.1 0-2-.9-2-2"></path>
                                      <circle cx="7" cy="4" r=".5"></circle>
                                      <circle cx="9" cy="4" r=".5"></circle>
                                    </svg>
                                    LAUNDRY
                                </h4>
                            </a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        @if(auth()->check() && auth()->user()->level->level_name === 'Super Admin')
                        <li class="sidebar-title">Data Master</li>

                        <li class="sidebar-item {{ Request::routeIs('levels.*') ? 'active' : '' }}">
                            <a href="{{ route('levels.index') }}" class='sidebar-link'>
                                <i class="bi bi-layers-fill"></i>
                                <span>Data Roles</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::routeIs('users.*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Data User</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::routeIs('customers.*') ? 'active' : '' }}">
                            <a href="{{ route('customers.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Data Customer</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::routeIs('type-of-services.*') ? 'active' : '' }}">
                            <a href="{{ route('type-of-services.index') }}" class='sidebar-link'>
                                <i class="bi bi-tags-fill"></i>
                                <span>Jenis Layanan</span>
                            </a>
                        </li>
                        @endif

                        @if(auth()->check() && in_array(auth()->user()->level->level_name, ['Super Admin', 'Operator']))
                        <li class="sidebar-title">Transaksi</li>

                        <li class="sidebar-item {{ Request::routeIs('orders.*') ? 'active' : '' }}">
                            <a href="{{ route('orders.index') }}" class='sidebar-link'>
                                <i class="bi bi-cart-fill"></i>
                                <span>Order Laundry</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::routeIs('pickups.*') ? 'active' : '' }}">
                            <a href="{{ route('pickups.index') }}" class='sidebar-link'>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Pengambilan</span>
                            </a>
                        </li>
                        @endif

                        @if(auth()->check() && in_array(auth()->user()->level->level_name, ['Super Admin', 'Pimpinan']))
                        <li class="sidebar-title">Laporan</li>

                        <li class="sidebar-item {{ Request::routeIs('reports.*') ? 'active' : '' }}">
                            <a href="{{ route('reports.index') }}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                                <span>Laporan Penjualan</span>
                            </a>
                        </li>
                        @endif

                        <li class="sidebar-title">Opsi</li>
                        <li class="sidebar-item">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="#" onclick="document.getElementById('logout-form').submit()" class='sidebar-link text-danger'>
                                    <i class="bi bi-box-arrow-right text-danger"></i>
                                    <span>Logout</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <h3 class="mb-0">@yield('title', 'Dashboard')</h3>
                        @if(auth()->check())
                        <div class="text-end">
                            <span class="badge bg-primary fs-6">
                                <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }} 
                                ({{ auth()->user()->level->level_name }})
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <section class="section">
                    @yield('content')
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2026 &copy; Laundry App</p>
                    </div>
                    <div class="float-end">
                        <p>Dibuat dengan <span class="text-danger"><i class="bi bi-heart-fill"></i></span> by Tim Laundry</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    
    <script>
        // Notifikasi Sukses
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        // Notifikasi Error/Gagal
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
            });
        @endif

        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                let form = this.closest('form');
                Swal.fire({
                    title: 'Yakin Ingin Menghapus?',
                    text: "Data Yang Dihapus Tidak Bisa Dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>