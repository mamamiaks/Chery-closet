<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\User; // tambahkan ini
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)

    {
        Pesanan::cekExpired();  
        $barang = Barang::findOrFail($id);

        return view('pesan.index', compact('barang'));
    }

public function pesan(Request $request, $id)
{
    $barang = Barang::where('id', $id)->first();
   $tanggal = Carbon::now('Asia/Jakarta');

    // Validasi stok
    if($request->jumlah_pesan > $barang->stok)
    {
        return redirect('pesan/'.$id)->with('error', 'Jumlah pesan melebihi stok yang tersedia');
    }

    // Cek apakah user sudah punya pesanan aktif
    $cek_pesanan = Pesanan::where('user_id', Auth::user()->id)
                    ->where('status', 0)
                    ->first();

    // Jika belum ada pesanan aktif
    if(empty($cek_pesanan))
    {
        $pesanan = new Pesanan;
        $pesanan->user_id = Auth::user()->id;
        $pesanan->tanggal = $tanggal;
        $pesanan->status = 0;
        $pesanan->jumlah_harga = 0;
        $pesanan->save();
    }

    // Ambil pesanan aktif user
    $pesanan_baru = Pesanan::where('user_id', Auth::user()->id)
                    ->where('status', 0)
                    ->first();

    // Cek apakah barang sudah ada di keranjang
    $cek_pesanan_detail = PesananDetail::where('barang_id', $barang->id)
                            ->where('pesanan_id', $pesanan_baru->id)
                            ->first();

    // Jika barang belum ada di keranjang
    if(empty($cek_pesanan_detail))
    {
        $pesanan_detail = new PesananDetail;
        $pesanan_detail->barang_id = $barang->id;
        $pesanan_detail->pesanan_id = $pesanan_baru->id;
        $pesanan_detail->jumlah = $request->jumlah_pesan;
        $pesanan_detail->jumlah_harga = $barang->harga * $request->jumlah_pesan;
        $pesanan_detail->save();

        // Update total harga pesanan
        $pesanan_baru->jumlah_harga =
            $pesanan_baru->jumlah_harga +
            ($barang->harga * $request->jumlah_pesan);

        $pesanan_baru->save();
    }
    else
    {
        // Jika barang sudah ada di keranjang
        $cek_pesanan_detail->jumlah =
            $cek_pesanan_detail->jumlah + $request->jumlah_pesan;

        $harga_tambah = $barang->harga * $request->jumlah_pesan;

        $cek_pesanan_detail->jumlah_harga =
            $cek_pesanan_detail->jumlah_harga + $harga_tambah;

        $cek_pesanan_detail->save();

        // Update total harga pesanan
        $pesanan_baru->jumlah_harga =
            $pesanan_baru->jumlah_harga + $harga_tambah;

        $pesanan_baru->save();
    }

   return redirect('/home')
    ->with('success', 'Barang berhasil masuk keranjang');
}
public function check_out()
{
    $pesanan = Pesanan::where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->first();

    $pesanan_details = collect();

    if($pesanan)
    {
        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)
                            ->get();
    }

    return view('pesan.check_out',
        compact('pesanan', 'pesanan_details'));
}

public function delete($id)
{
    $pesanan_detail = PesananDetail::find($id);

    if (!$pesanan_detail) {
        return redirect('check-out');
    }

    $pesanan = Pesanan::find($pesanan_detail->pesanan_id);

    $pesanan->jumlah_harga =
        $pesanan->jumlah_harga -
        $pesanan_detail->jumlah_harga;

    $pesanan->save();

    $pesanan_detail->delete();

    // Cek apakah masih ada barang di keranjang
    $sisa_pesanan = PesananDetail::where('pesanan_id', $pesanan->id)->count();

    // Jika sudah tidak ada barang, hapus pesanan juga
    if($sisa_pesanan == 0)
    {
        $pesanan->delete();
    }

    return redirect('check-out')
        ->with('success', 'Pesanan berhasil dihapus');
}
public function konfirmasi()
{
    $user = User::find(Auth::id());

    if (empty($user->alamat))
{
    return redirect('profile')
        ->with('error', 'Alamat dan NoHp harus diisi terlebih dahulu');
}

if (empty($user->nohp))
{
    return redirect('profile')
        ->with('error', 'Nomor HP harus diisi terlebih dahulu');
}

    $pesanan = Pesanan::where('user_id', Auth::id())
                      ->where('status', 0)
                      ->first();

    if(!$pesanan)
    {
        return redirect('check-out')
            ->with('error', 'Tidak ada pesanan');
    }

    $pesanan_id = $pesanan->id;

// generate kode unik 3 digit
$kode_unik = rand(100,999);

$pesanan->kode_unik = $kode_unik;
$pesanan->jumlah_harga = $pesanan->jumlah_harga + $kode_unik;
$pesanan->status = 1;

$pesanan->batas_bayar = now()->addHour();
$pesanan->expired_at = now()->addHour();

$pesanan->save();

    $pesanan_details = PesananDetail::where('pesanan_id', $pesanan_id)->get();

 foreach ($pesanan_details as $pesanan_detail)
{
    $barang = Barang::find($pesanan_detail->barang_id);

    if($barang)
    {
        $barang->stok -= $pesanan_detail->jumlah;
        $barang->save();
    }
}

return redirect('history/'.$pesanan_id)
    ->with('success', 'Pesanan berhasil checkout');
}
}