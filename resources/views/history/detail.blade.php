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
                    <a href="{{ url('history') }}">Riwayat Pemesanan</a>
                </li>
                <li class="breadcrumb-item active">
                    Detail Pemesanan
                </li>
            </ol>
        </nav>
    </div>

    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body">

                <h3>Sukses Check Out</h3>

                <p>
                    Pesanan anda sudah sukses di checkout,
                    selanjutnya untuk pembayaran silahkan transfer ke rekening:

                    <strong>Bank BRI</strong>

                    Nomor Rekening :
                    <strong>32113-821312-123</strong>

                    <br><br>

Kode Unik :
<strong>
    {{ $pesanan->kode_unik }}
</strong>

<br><br>

Total Transfer :

<strong>
    Rp.
    {{ number_format($pesanan->jumlah_harga,0,',','.') }}
</strong>

<br><br>

Batas Pembayaran :

<strong>
    {{ \Carbon\Carbon::parse($pesanan->batas_bayar)->format('d M Y H:i') }}
</strong>

<br><br>

Status :

@if($pesanan->status == 1)
    <span class="badge bg-warning">
        Belum Dibayar
    </span>

@elseif($pesanan->status == 2)
    <span class="badge bg-info">
        Menunggu Verifikasi
    </span>

@elseif($pesanan->status == 3)
    <span class="badge bg-success">
        Sudah Dibayar
    </span>

@elseif($pesanan->status == 4)
    <span class="badge bg-danger">
        Dibatalkan
    </span>
@endif
                </p>
@if($pesanan->status == 1)

<form action="{{ url('upload-bukti/'.$pesanan->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div class="mb-3">
        <label class="form-label">
            Upload Bukti Transfer
        </label>

        <input type="file"
               name="bukti_transfer"
               class="form-control"
               required>
    </div>

    <button type="submit"
            class="btn btn-primary">

        Upload Bukti Transfer

    </button>

</form>

@endif
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="card">

            <div class="card-body">

                <h3>
                    <i class="fa fa-shopping-cart"></i>
                    Detail Pemesanan
                </h3>

                <p class="text-right">
                    Tanggal Pesan :
                    {{ $pesanan->tanggal }}
                </p>

                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>

                    <tbody>

                    @php
                        $no = 1;
                    @endphp

                    @foreach($pesanan_details as $detail)

                    <tr>

                        <td>{{ $no++ }}</td>

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

                    <tr>
                        <td colspan="4" align="right">
                            <strong>Total Harga :</strong>
                        </td>

                        <td>
                            <strong>
                                Rp.
                                {{ number_format($pesanan->jumlah_harga,0,',','.') }}
                            </strong>
                        </td>
                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


</div>

@endsection
