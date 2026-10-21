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
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ url('admin/pesanan') }}">Data Pesanan</a>
                </li>
                <li class="breadcrumb-item active">
                    Detail Data Pesanan
                </li>
            </ol>
        </nav>
    </div>

<div class="container">

    <div class="card">

        <div class="card-body">

            <h3>Detail Pesanan</h3>

            <p>
                <strong>User :</strong>
                {{ $pesanan->user->name }}
            </p>

            <p>
                <strong>Tanggal :</strong>
                {{ $pesanan->tanggal }}
            </p>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($pesanan_details as $detail)

                <tr>

                    <td>
                        {{ $detail->barang->nama_barang }}
                    </td>

                    <td>
                        {{ $detail->jumlah }}
                    </td>

                    <td>
                        Rp.
                        {{ number_format($detail->barang->harga,0,',','.') }}
                    </td>

                    <td>
                        Rp.
                        {{ number_format($detail->jumlah_harga,0,',','.') }}
                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection