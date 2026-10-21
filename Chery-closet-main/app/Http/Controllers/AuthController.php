<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($data))
        {
            return redirect('/');
        }   

        return back()->with('error', 'Login gagal');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}