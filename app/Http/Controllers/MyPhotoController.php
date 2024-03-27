<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MyPhotoController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman my photo
     *
     * @return void
     */
    public function index()
    {
        $photos = Foto::query()
            ->where('user_id', Auth::user()->id)
            ->with('belongsToUser')
            ->get();

        return view('my-photo', compact('photos'));
    }
}
