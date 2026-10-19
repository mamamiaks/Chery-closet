<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananDetail;
use iumiluminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function pembayaran()
    {
        if(!Auth::check()) {
            return redirect('/login')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
        Pesanan::cekExpired();
       $pesanans = Pesanan::whereIn('status', [2,3])
            ->orderBy('id','DESC')
            ->get();
            
        return view(
            'admin.pembayaran',
            compact('pesanans')
        );
    }

    public function approve($id)
    {
        if(!Auth::check()) {
            return redirect('/login')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status = 3;

        $pesanan->save();

        return redirect('/admin/pembayaran')
            ->with(
                'success',
                'Pembayaran berhasil diverifikasi'
            );
    }



public function laporan()
{
    if(!Auth::check()) {
            return redirect('/login')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
    $details = PesananDetail::with([
        'barang',
        'pesanan.user'
    ])
    ->whereHas('pesanan.user')
    ->get();

    $totalOmset = 0;
    $totalModal = 0;

    foreach($details as $detail)
    {
        if($detail->barang)
        {
            $totalOmset += $detail->jumlah_harga;

            $totalModal +=
                $detail->jumlah *
                $detail->barang->harga_modal;
        }
    }

$totalProfit = $totalOmset - $totalModal;

$omsetBulanan = 0;
$modalBulanan = 0;
$profitBulanan = 0;

if(request('bulan'))
{
    $bulan = explode('-', request('bulan'));

    $detailBulanan = PesananDetail::with('barang')
        ->whereMonth('created_at', $bulan[1])
        ->whereYear('created_at', $bulan[0])
        ->get();

    foreach($detailBulanan as $detail)
    {
        $omsetBulanan += $detail->jumlah_harga;

        if($detail->barang)
        {
            $modalBulanan +=
                $detail->jumlah *
                $detail->barang->harga_modal;
        }
    }

    $profitBulanan =
        $omsetBulanan -
        $modalBulanan;
}

return view(
        'admin.laporan',
        compact(
    'totalOmset',
    'totalModal',
    'totalProfit',
    'details',
    
    'omsetBulanan',
    'modalBulanan',
    'profitBulanan'
)
    );
}
}