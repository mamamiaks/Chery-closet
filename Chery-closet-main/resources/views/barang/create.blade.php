@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header">

            @if(isset($barang))
                <h4>Edit Barang</h4>
            @else
                <h4>Tambah Barang</h4>
            @endif

        </div>

        <div class="card-body">

            @if(isset($barang))
                <form action="{{ url('/barang/update/'.$barang->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
            @else
                <form action="/barang/tambah"
                      method="POST"
                      enctype="multipart/form-data">
            @endif

                @csrf

                <div class="mb-3">
                    <label>Nama Barang</label>

                    <input
                        type="text"
                        name="nama_barang"
                        class="form-control"
                        value="{{ $barang->nama_barang ?? '' }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>Harga</label>

                    <input
                        type="number"
                        name="harga"
                        class="form-control"
                        value="{{ $barang->harga ?? '' }}"
                        required>
                </div>

                <div class="mb-3">
    <label>Harga Modal</label>

    <input
        type="number"
        name="harga_modal"
        class="form-control"
        value="{{ $barang->harga_modal ?? '' }}"
        required>
</div>

                <div class="mb-3">
                    <label>Stok</label>

                    <input
                        type="number"
                        name="stok"
                        class="form-control"
                        value="{{ $barang->stok ?? '' }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>

                    <textarea
                        name="keterangan"
                        class="form-control"
                        rows="3"
                        required>{{ $barang->keterangan ?? '' }}</textarea>
                </div>

                @if(isset($barang) && $barang->gambar)

                <div class="mb-3">
                    <label>Gambar Saat Ini</label>
                    <br>

                    <img
                        src="{{ asset('uploads/'.$barang->gambar) }}"
                        width="150"
                        class="rounded">
                </div>

                @endif

                <div class="mb-3">
                    <label>Gambar</label>

                    <input
                        type="file"
                        name="gambar"
                        class="form-control">
                </div>

                @if(isset($barang))

                    <button
                        type="submit"
                        class="btn btn-warning">
                        Update Barang
                    </button>

                @else

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Simpan Barang
                    </button>

                @endif

            </form>

        </div>
    </div>

</div>
@endsection