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
                        Riwayat Pemesanan
                    </li>
                </ol>
            </nav>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <h3>
                        <i class="fa fa-history"></i>
                        Riwayat Pemesanan
                    </h3>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        @php $no = 1; @endphp

                        @foreach($pesanans as $pesanan)

                        <tr>

                            <td>{{ $no++ }}</td>

                            <td>{{ $pesanan->tanggal }}</td>

                            <td>

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

</td>

                            <td>
                                Rp {{ number_format($pesanan->jumlah_harga,0,',','.') }}
                            </td>

                            <td>
                                <a href="{{ url('history/'.$pesanan->id) }}"
                                   class="btn btn-sm btn-primary">
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

    </div>
</div>

@endsection