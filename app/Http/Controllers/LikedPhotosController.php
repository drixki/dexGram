<?php

namespace App\Http\Controllers;

use App\Models\User;

class LikedPhotosController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman liked photos
     *
     * @return void
     */
    public function view()
    {
        $user = User::find(auth()->id());
        $photos = $user->likes()->withTrashed()->get();

        return view('liked-photos', compact('photos'));
    }
}
