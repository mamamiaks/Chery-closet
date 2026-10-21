<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Barang;
use App\Models\PesananDetail;

class Pesanan extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function cekExpired()
{
    $expiredPesanan = self::where('status',1)
        ->where('batas_bayar','<',Carbon::now())
        ->get();

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
}
}