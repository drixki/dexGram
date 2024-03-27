<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Fungsi untuk like dan unlike foto
     *
     * @param  mixed $photo
     * @return void
     */
    public function like(Foto $photo)
    {
        $userId = Auth::user()->id;

        $isLiked = $photo->isLiked();

        if ($isLiked) {
            $photo->likes()->detach($userId);
        } else {
            $photo->likes()->attach($userId);
        }

        $likesCount = $photo->likesCount();

        return response()->json(['likes_count' => $likesCount, 'is_liked' => !$isLiked]);
    }

    /**
     * Fungsi untuk unlike
     *
     * @param  mixed $id
     * @return void
     */
    public function unlike(string $id)
    {
        $photo = Foto::withTrashed()->find($id);
        $photo->likes()->detach(auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus'
        ]);
    }
}
