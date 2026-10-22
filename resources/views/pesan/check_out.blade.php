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
                <li class="breadcrumb-item active" aria-current="page">
                    Check Out
                </li>
            </ol>
        </nav>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <h3>
                    <i class="fa fa-shopping-cart"></i>
                    Check Out
                </h3>

                @if(!empty($pesanan))

                <p align="right">
                    Tanggal Pesan : {{ $pesanan->tanggal }}
                </p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php $no = 1; @endphp

                        @foreach($pesanan_details as $pesanan_detail)

                        <tr>

                            <td>{{ $no++ }}</td>

                            <td>
                                <img src="{{ url('uploads/'.$pesanan_detail->barang->gambar) }}"
                                     width="100"
                                     height="100"
                                     style="object-fit:cover;border-radius:10px;">
                            </td>

                            <td>
                                {{ $pesanan_detail->barang->nama_barang  ?? 'Barang sudah tidak tersedia'}}
                            </td>

                            <td>
                                {{ $pesanan_detail->jumlah ? number_format($pesanan_detail->barang -> harga) : '0' }} item
                            </td>

                            <td>
                                Rp. {{ number_format($pesanan_detail->barang->harga ?? 0) }}
                            </td>

                            <td>
                                Rp. {{ number_format($pesanan_detail->jumlah_harga ?? 0) }}
                            </td>

                            <td>
                                <a href="{{ url('check-out/'.$pesanan_detail->id) }}"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>

                        </tr>

                        @endforeach

                        <tr>
                            <td colspan="5" align="right">
                                <strong>Total Harga :</strong>
                            </td>

                            <td>
                                <strong>
                                    Rp. {{ number_format($pesanan->jumlah_harga) }}
                                </strong>
                            </td>

                            <td>
                                <a href="{{ url('konfirmasi-check-out') }}"
                                   class="btn btn-success"
                                   onclick="return confirm('Yakin akan Check Out ?')">
                                    <i class="fa fa-shopping-cart"></i>
                                    Check Out
                                </a>
                            </td>
                        </tr>

                    </tbody>
                </table>

                @endif

            </div>
        </div>
    </div>

</div>


</div>
@endsection
