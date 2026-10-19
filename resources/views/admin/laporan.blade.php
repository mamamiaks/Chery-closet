@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">


    <div class="col-md-12">
        <a href="{{ url('history') }}" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="col-md-12 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('home') }}">Home</a>
                
                <li class="breadcrumb-item active">
                    Laporan Pembayaran
                </li>
            </ol>
        </nav>
    </div>

<div class="container">

    <h2 class="mb-4">
        📊 Laporan Keuntungan
    </h2>

    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Omset</h5>

                    <h3 class="text-primary">
                        Rp {{ number_format($totalOmset,0,',','.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Modal</h5>

                    <h3 class="text-warning">
                        Rp {{ number_format($totalModal,0,',','.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Profit</h5>

                    <h3 class="text-success">
                        Rp {{ number_format($totalProfit,0,',','.') }}
                    </h3>
                </div>
            </div>
        </div>

    </div>
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h4>📅 Laporan Bulanan</h4>
    </div>

    <div class="card-body">

        <form method="GET" action="{{ url('/admin/laporan') }}">

            <div class="row">

                <div class="col-md-4">
                    <input
                        type="month"
                        name="bulan"
                        class="form-control"
                        value="{{ request('bulan') }}">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary">
                        Tampilkan
                    </button>
                </div>

            </div>

        </form>

        @if(isset($omsetBulanan))

        <hr>

        <h5>Bulan : {{ request('bulan') }}</h5>

        <table class="table table-bordered mt-3">
            <tr>
                <th>Total Omset</th>
                <td>
                    Rp {{ number_format($omsetBulanan,0,',','.') }}
                </td>
            </tr>

            <tr>
                <th>Total Modal</th>
                <td>
                    Rp {{ number_format($modalBulanan,0,',','.') }}
                </td>
            </tr>

            <tr>
                <th>Total Profit</th>
                <td>
                    Rp {{ number_format($profitBulanan,0,',','.') }}
                </td>
            </tr>
        </table>

        @endif

    </div>
</div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Detail Pembelian Customer</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Harga Jual</th>
                        <th>Subtotal</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($details as $detail)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $detail->pesanan->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->barang->nama_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->jumlah }}
                        </td>

                        <td>
    Rp {{ number_format($detail->jumlah_harga / $detail->jumlah,0,',','.') }}
</td>

                        <td>
    Rp {{ number_format($detail->jumlah_harga,0,',','.') }}
</td>

<td>
    {{ date('d-m-Y', strtotime($detail->created_at)) }}
</td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection