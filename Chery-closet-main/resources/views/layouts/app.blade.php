<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CHERIE CLOSET') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
body{
    font-family: 'Poppins', sans-serif;

    background-image: url('{{ asset("uploads/wallpaper.jpg") }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;

    min-height:100vh;
}

/* NAVBAR */
.navbar{
    background: linear-gradient(
        90deg,
        #ffd6e7,
        #ffc7dd
    ) !important;
    backdrop-filter: blur(15px);
    border-bottom: 1px solid #ffcade;
     position: relative;
    z-index: 99999;
}

.navbar-brand{
    color:#ff6fa5 !important;
    font-size:28px;
    font-weight:700;
}

.nav-link{
    color:#8d6e63 !important;
    font-weight:500;
}

.nav-link:hover{
    color:#ff5c98 !important;
}

/* CARD */
.card{
    border:none;
    border-radius:30px;
    overflow:hidden;
    background:#ffffff;
    box-shadow:
        0 10px 30px rgba(255,182,193,.12),
        0 3px 10px rgba(255,228,225,.25);
    transition:.3s;
}

.card:hover{
    transform:translateY(-6px);
}

.card-header{
    background:#fff;
    border:none;
    color:#f48fb1;
    font-size:26px;
    font-weight:700;
    text-align:center;
    padding:25px;
}

/* GAMBAR PRODUK */
.card-img-top{
    width:100%;
    height:260px;
    object-fit:cover;
}

/* INPUT */
.form-control{
    border:2px solid #ffe4ec;
    border-radius:18px;
    padding:12px;
    background:#fffdfd;
}

.form-control:focus{
    border-color:#f8bbd0;
    box-shadow:0 0 0 .2rem rgba(248,187,208,.15);
}

/* BUTTON */
.btn-primary{
    background:linear-gradient(
        135deg,
        #ff8fba,
        #ff6fa5
    );
    border:none;
    border-radius:18px;
    padding:12px 30px;
    font-weight:700;
    box-shadow:0 5px 15px rgba(255,111,165,.25);
}

.btn-primary:hover{
    background:linear-gradient(
        135deg,
        #ff6fa5,
        #ff4f95
    );
    transform:translateY(-2px);
}

.col-form-label{
    color:#ff6fa5;
    font-weight:600;
}
.btn-link,
a{
    color:#ff6fa5 !important;
    font-weight:500;
}

.btn-link:hover,
a:hover{
    color:#ff4f95 !important;
}
/* LINK */
a{
    color:#f48fb1;
    text-decoration:none;
}

a:hover{
    color:#ec7fa8;
}

/* DROPDOWN */
.dropdown-menu{
    min-width:260px;
    overflow:visible !important;
    max-height:none !important;

    border:none;
    border-radius:20px;
    background:#fffdfd;
    box-shadow:0 10px 25px rgba(255,182,193,.15);
    z-index:99999;
}

.dropdown-item:hover{
    background:#fff2f7;
}

/* LOGIN REGISTER */
.auth-card{
    max-width:520px;
    margin:auto;
}

/* DETAIL PRODUK */
.product-image{
    width:100%;
    height:420px;
    object-fit:cover;
    border-radius:25px;
}

/* BREADCRUMB */
.breadcrumb{
    background:#fffdfb;
    border-radius:18px;
    padding:14px 20px;
    box-shadow:0 4px 15px rgba(255,182,193,.08);
}

/* TABLE */
.table td{
    padding:12px;
    border-color:#ffe6ef;
}

/* SWEET TITLE */
.page-title{
    color:#f48fb1;
    font-weight:700;
}

/* SCROLLBAR */
::-webkit-scrollbar{
    width:8px;
}

::-webkit-scrollbar-thumb{
    background:#f8bbd0;
    border-radius:20px;
}

::-webkit-scrollbar-track{
    background:#fff7fa;
}

.btn-primary{
    color:white !important;
}

.btn-primary:hover{
    color:white !important;
}

.btn{
    color:white !important;
    font-weight:600;
}

.btn-link{
    color:#ff6fa5 !important;
    font-weight:600;
    text-decoration:none;
}

.btn-link:hover{
    color:#ff4f95 !important;
}

.table img{
    width:100px;
    height:100px;
    object-fit:cover;
    border-radius:12px;
}
</style>
</head>
<body>

<div id="app">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                CHERIE CLOSET
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto">
 

<?php

$notif = 0;

if(Auth::check())
{
    $pesanan_utama = \App\Models\Pesanan::where('user_id', Auth::user()->id)
                        ->where('status', 0)
                        ->first();

    if($pesanan_utama)
    {
        $notif = \App\Models\PesananDetail::where('pesanan_id', $pesanan_utama->id)
                    ->count();
    }
}

?>


@guest
                   

                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    Login
                                </a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    Register
                                </a>
                            </li>
                        @endif

                 @else

    <li class="nav-item">
        <a class="nav-link position-relative" href="{{ url('check-out') }}">
            <i class="fa-solid fa-cart-shopping"></i>

            @if($notif > 0)
                <span class="badge bg-danger">
                    {{ $notif }}
                </span>
            @endif
        </a>
    </li>

    <li class="nav-item dropdown">

        <a id="navbarDropdown"
   class="nav-link dropdown-toggle"
   href="#"
   role="button"
   data-bs-toggle="dropdown">

    {{ Auth::user()->name }}

</a>

<ul class="dropdown-menu dropdown-menu-end">

    <li>
        <a class="dropdown-item" href="{{ url('/profile') }}">
            👤 Profile
        </a>
    </li>

    <li><hr class="dropdown-divider"></li>

  @if(Auth::user()->role == 'admin')

<li>
    <a class="dropdown-item" href="{{ url('/barang/tambah') }}">
        ➕ Tambah Barang
    </a>
</li>
 <li><hr class="dropdown-divider"></li>
<li>
    <a class="dropdown-item" href="{{ url('/barang') }}">
        ✏️ Kelola Barang
    </a>
</li>
 <li><hr class="dropdown-divider"></li>
<li>
    <a class="dropdown-item" href="{{ url('/admin/pembayaran') }}">
        💳 Verifikasi Pembayaran
    </a>
</li>
 <li><hr class="dropdown-divider"></li>
<li>
    <a class="dropdown-item" href="{{ url('/admin/pesanan') }}">
        📦 Data Pesanan
    </a>
</li>
 <li><hr class="dropdown-divider"></li>

 <li>
    <a class="dropdown-item"
       href="{{ url('/admin/laporan') }}">
        📊 Laporan Bulanan
    </a>
</li>

<li><hr class="dropdown-divider"></li>
<li>
    <a class="dropdown-item" href="{{ url('/admin/user') }}">
        👥 Data User
    </a>
</li>

@else

<li>
    <a class="dropdown-item" href="{{ url('/history') }}">
        📦 Riwayat Pemesanan
    </a>
</li>

@endif

    <li><hr class="dropdown-divider"></li>

    <li>
        <a class="dropdown-item"
           href="{{ route('logout') }}"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();">
            🚪 Logout
        </a>
    </li>

</ul>
                            <form id="logout-form"
                                  action="{{ route('logout') }}"
                                  method="POST"
                                  class="d-none">
                                @csrf
                            </form>

                        </li>

                    @endguest

                </ul>

            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session("success") }}',
        confirmButtonColor: '#ff69b4',
        timer: 1500,
        timerProgressBar: true,
        showConfirmButton: false
    });
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session("error") }}',
        confirmButtonColor: '#ff69b4'
    });
});
</script>
@endif

</body>
</html>