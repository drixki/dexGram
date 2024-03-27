<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    /**
     * Fungsi untuk mencari foto
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function search(Request $request)
    {
        // Mendapatkan kata kunci pencarian dari request
        $keyword = Str::slug($request->keyword);

        // Melakukan pencarian foto berdasarkan judul atau deskripsi yang mengandung kata kunci
        if ($keyword != null) {
            $photos = Foto::query()
                ->where('visibility', 'public')
                ->where(function ($query) use ($keyword) {
                    $query->where('slug', 'like', "%{$keyword}%");
                })
                ->with('belongsToUser')
                ->get();
        } else {
            $photos = null;
        }

        return response()->json($photos);
    }
}
