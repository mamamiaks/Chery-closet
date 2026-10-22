@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Verifikasi Pembayaran
    </h2>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama User</th>
                        <th>Total Transfer</th>
                        <th>Bukti Transfer</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($pesanans as $pesanan)

                    <tr>

                        <td>
                            {{ $pesanan->id }}
                        </td>

                        <td>
                            {{ $pesanan->user->name ?? 'Pengguna tidak ditemukan' }}
                        </td>

                        <td>
                            Rp.
                            {{ number_format($pesanan->jumlah_harga,0,',','.') }}
                        </td>

                        <td>

                            @if($pesanan->bukti_transfer)

                            <img
                                src="{{ asset('bukti_transfer/'.$pesanan->bukti_transfer) }}"
                                width="150">

                            @endif

                        </td>
                        <td>

    @if($pesanan->status == 2)

        <span class="badge bg-warning">
            Menunggu Verifikasi
        </span>

    @elseif($pesanan->status == 3)

        <span class="badge bg-success">
            Sudah Dibayar
        </span>

    @endif

</td>

                       <td>

    @if($pesanan->status == 2)

        <a href="{{ url('admin/approve/'.$pesanan->id) }}"
           class="btn btn-success"
           onclick="return confirm('Approve pembayaran ini?')">

            Approve

        </a>

    @else

        <span class="text-success fw-bold">
            ✔ Sudah Approve
        </span>

    @endif

</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection