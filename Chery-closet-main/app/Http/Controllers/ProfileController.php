<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);

        return view('profile.index', compact('user'));
    }

public function update(Request $request)
{
    $user = User::find(Auth::user()->id);

    $user->name   = $request->name;
    $user->email  = $request->email;
    $user->nohp   = $request->nohp;
    $user->alamat = $request->alamat;

    // Upload foto profil
    if($request->hasFile('foto'))
    {
        $file = $request->file('foto');

        $namaFile = time().'.'.$file->getClientOriginalExtension();

        $file->move(
            public_path('uploads/profile'),
            $namaFile
        );

        $user->foto = $namaFile;
    }

    // Update password jika diisi
    if (!empty($request->password))
    {
        $this->validate($request, [
            'password' => 'confirmed|min:6'
        ]);

        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect('/profile')
           ->with('success', 'Profil berhasil diperbarui');
}
}