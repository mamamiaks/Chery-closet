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
                        Kelola Barang
                    </li>
                </ol>
            </nav>
        </div>

<div class="container">

    <h3>Kelola Barang</h3>

    <a href="{{ url('/barang/tambah') }}"
       class="btn btn-success mb-3">
       Tambah Barang
    </a>

    <table class="table table-bordered">

        <thead>
            <tr>
               <th>Nama Barang</th>
               <th>Keterangan</th>
<th>Harga Modal</th>
<th>Harga Jual</th>
<th>Profit</th>
<th>Stok</th>
<th>Aksi</th>
            </tr>
        </thead>

      <tbody>

@foreach($barangs as $barang)

<tr>

    <td>{{ $barang->nama_barang }}</td>
    <td>{{ $barang->keterangan }}</td>

    <td>
        Rp {{ number_format($barang->harga_modal,0,',','.') }}
    </td>

    <td>
        Rp {{ number_format($barang->harga,0,',','.') }}
    </td>

    <td>
        Rp {{ number_format($barang->harga - $barang->harga_modal,0,',','.') }}
    </td>

    <td>{{ $barang->stok }}</td>

    <td>
        <a href="{{ url('/barang/edit/'.$barang->id) }}"
           class="btn btn-warning btn-sm">
            Edit
        </a>

        <a href="{{ url('/barang/delete/'.$barang->id) }}"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin ingin menghapus barang ini?')">
            Hapus
        </a>
    </td>

</tr>

@endforeach

</tbody>

    </table>

</div>

@endsection