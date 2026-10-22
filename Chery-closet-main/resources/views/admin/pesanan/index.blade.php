@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <a href="{{ url('home') }}" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="col-md-12 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Data Pesanan
                    </li>
                </ol>
            </nav>
        </div>

<div class="container">

    <div class="card">

        <div class="card-body">

            <h3>Data Pesanan</h3>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($pesanans as $pesanan)

                <tr>

                    <td>{{ $pesanan->id }}</td>

                    <td>{{ $pesanan->user->name ?? 'user tidak ditemukan'}}</td>

                    <td>{{ $pesanan->tanggal }}</td>

                    <td>
                        Rp.
                        {{ number_format($pesanan->jumlah_harga,0,',','.') }}
                    </td>

                    <td>

                        @if($pesanan->status == 1)
                            Belum Dibayar
                        @elseif($pesanan->status == 2)
                            Menunggu Verifikasi
                        @elseif($pesanan->status == 3)
                            Sudah Dibayar
                        @elseif($pesanan->status == 4)
                            Dibatalkan
                        @endif

                    </td>

                    <td>

                        <a href="{{ url('/admin/pesanan/'.$pesanan->id) }}"
                           class="btn btn-primary btn-sm">

                            Detail

                        </a>

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection