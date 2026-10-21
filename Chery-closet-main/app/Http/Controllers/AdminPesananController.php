<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPesananController extends Controller
{
    public function index()
    {
        if(!Auth::check()) {
            return redirect('/login')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
        $pesanans = Pesanan::where('status','!=',0)
                    ->orderBy('id','DESC')
                    ->get();

        return view(
            'admin.pesanan.index',
            compact('pesanans')
        );
    }

    public function detail($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan_details =
            PesananDetail::where(
                'pesanan_id',
                $pesanan->id
            )->get();

        return view(
            'admin.pesanan.detail',
            compact(
                'pesanan',
                'pesanan_details'
            )
        );
    }
}