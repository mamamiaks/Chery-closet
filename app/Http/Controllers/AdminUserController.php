<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view(
            'admin.user.index',
            compact('users')
        );
    }

    public function delete($id)
    {
        if(!Auth::check()) {
            return redirect('/login')->with('error', 'Unauthorized action.');
        }
        if(!Auth::user()->hasRole('admin')) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }
        $user = User::findOrFail($id);

        if($user->role == 'admin')
        {
            return back();
        }

        $user->delete();

        return back()
            ->with(
                'success',
                'User berhasil dihapus'
            );
    }
}