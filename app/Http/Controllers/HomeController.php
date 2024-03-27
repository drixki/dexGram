<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan Halaman utama dari aplikasi Photopie.
     *
     * @return void
     */
    public function index()
    {
        $photos = Foto::query()
            ->inRandomOrder()
            ->with('belongsToUser')
            ->where('visibility', 'public')
            ->get();

        $user = Auth::user();
        $likedPhotos = $user->likes()->take(10)->get();
        $followingPhotos = $user->following()->take(10)->get();

        return view('home', compact('photos', 'likedPhotos', 'followingPhotos'));
    }
}
