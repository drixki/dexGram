<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadOrUpdateController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman create photo
     *
     * @return void
     */
    public function create()
    {
        $category = Auth::user()->category()->get();
        return view('form-photo', compact('category'));
    }

    /**
     * Fungsi untuk menampilkan halaman edit photo
     *
     * @param  mixed $photo
     * @return void
     */
    public function edit(Foto $photo)
    {
        $user = Auth::user();

        if (!$user->hasManyPhotos->contains($photo)) {
            return back()->with('warning', 'Anda tidak memiliki izin');
        }

        $category = $user->category;

        return view('form-photo', compact('photo', 'category'));
    }
}
