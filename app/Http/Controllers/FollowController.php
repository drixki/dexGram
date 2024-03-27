<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Fungsi untuk follow atau un follow user
     *
     * @param  mixed $user
     * @return void
     */
    public function follow(User $user)
    {
        if (Auth::user()->followed($user->id)) {
            Auth::user()->following()->detach($user->id);

            return back()->with('success', 'Berhasil batal mengikuti ' . $user->name);
        } else {
            Auth::user()->following()->attach($user->id);

            return back()->with('success', 'Berhasil mengikuti ' . $user->name);
        }
    }

    /**
     * Fungsi untuk menampilkan halaman my following
     *
     * @return void
     */
    public function myFollowings()
    {
        $user = Auth::user();
        return view('my-followings', compact('user'));
    }
}
