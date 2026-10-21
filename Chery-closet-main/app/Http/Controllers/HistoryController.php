<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Barang;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index()
{
    Pesanan::cekExpired();

    $pesanans = Pesanan::where('user_id', Auth::user()->id)
                ->where('status', '!=', 0)
                ->orderBy('id', 'DESC')
                ->get();

    return view('history.index', compact('pesanans'));

    foreach($expiredPesanan as $pesanan)
    {
        $details = PesananDetail::where(
            'pesanan_id',
            $pesanan->id
        )->get();

        foreach($details as $detail)
        {
            $barang = Barang::find($detail->barang_id);

            if($barang)
            {
                $barang->stok += $detail->jumlah;
                $barang->save();
            }
        }

        $pesanan->status = 4;
        $pesanan->save();
    }

    $pesanans = Pesanan::where('user_id', Auth::user()->id)
                ->where('status', '!=', 0)
                ->orderBy('id', 'DESC')
                ->get();

    return view('history.index', compact('pesanans'));
}

    public function detail($id)
    {
        $pesanan = Pesanan::where('id', $id)
                    ->where('user_id', Auth::user()->id)
                    ->firstOrFail();

        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)
                            ->get();

        return view('history.detail', compact('pesanan', 'pesanan_details'));
    }

public function uploadBukti(Request $request, $id)
{
    $pesanan = Pesanan::findOrFail($id);

    if(
        $pesanan->status == 4 ||
        (
            $pesanan->expired_at &&
            now()->gt($pesanan->expired_at)
        )
    )
    {
        return back()->with(
            'error',
            'Pesanan sudah dibatalkan karena melebihi batas pembayaran 1 jam'
        );
    }

    if($request->hasFile('bukti_transfer'))
    {
        $file = $request->file('bukti_transfer');

        $nama_file = time().'.'.$file->getClientOriginalExtension();

        $file->move(
            public_path('bukti_transfer'),
            $nama_file
        );

        $pesanan->bukti_transfer = $nama_file;

        $pesanan->status = 2;

        $pesanan->save();
    }

    return back()->with(
        'success',
        'Bukti transfer berhasil diupload'
    );
}
}