<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
class BarangController extends Controller
{
    public function index()
    {
        if(!Auth::check()) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
        $barangs = Barang::all();

        return view('barang.index', compact('barangs'));
    }

    // FORM TAMBAH
    public function create()
    {
        if(!Auth::check()) {
            return redirect('/login')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
        $barang = null;

        return view('barang.create', compact('barang'));
    }

    // SIMPAN BARANG BARU
    public function store(Request $request)
    {
        $request->validate([
    'nama_barang' => 'required',
    'harga' => 'required',
    'harga_modal' => 'required',
    'stok' => 'required',
    'keterangan' => 'required',
    'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
]);

        $barang = new Barang();

        $barang->nama_barang = $request->nama_barang;
        $barang->harga = $request->harga;
        $barang->harga_modal = $request->harga_modal;
        $barang->stok = $request->stok;
        $barang->keterangan = $request->keterangan;

        if ($request->hasFile('gambar'))
        {
            $file = $request->file('gambar');

            $namaFile = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads'), $namaFile);

            $barang->gambar = $namaFile;
        }

        $barang->save();

        return redirect('/home')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit($id)
    {
        if(!Auth::check()) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
        $barang = Barang::findOrFail($id);

        return view('barang.create', compact('barang'));
    }

    public function update(Request $request, $id)
{
        if(!Auth::check()) {
            return redirect('/login')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
    $barang = Barang::findOrFail($id);

    $barang->nama_barang = $request->nama_barang;
    $barang->harga = $request->harga;
    $barang->stok = $request->stok;
    $barang->keterangan = $request->keterangan;

    if($request->hasFile('gambar'))
    {
        $file = $request->file('gambar');

        $namaFile = time().'.'.$file->getClientOriginalExtension();

        $file->move(public_path('uploads'), $namaFile);

        $barang->gambar = $namaFile;
    }

    $barang->save();

    return redirect('/barang');
}

public function destroy($id)
{
    if(!Auth::check()) {
            return redirect('/login')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
    $barang = Barang::findOrFail($id);

    if($barang->gambar)
    {
        $path = public_path('uploads/'.$barang->gambar);

        if(file_exists($path))
        {
            unlink($path);
        }
    }

    $barang->delete();

    return redirect('/barang')
        ->with('success', 'Barang berhasil dihapus');
}
}