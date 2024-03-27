<?php

namespace App\Http\Controllers;

use App\Models\KomentarFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    /**
     * Fungsi untuk menambah komentar
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);


        KomentarFoto::create([
            'foto_id' => $request->foto_id,
            'user_id' => Auth::user()->id,
            'content' => $request->content
        ]);

        return back()->with('success', 'Berhasil membuat komentar!');
    }

    /**
     * Fungsi untuk delete komentar
     *
     * @param  mixed $comment
     * @return void
     */
    public function deleteComment(KomentarFoto $comment)
    {
        $comment->delete();

        return back()->with('success', 'Berhasil menghapus komentar!');
    }

    /**
     * Keperluan testing
     *
     * @param  mixed $id
     * @return void
     */
    public function developer(string $id)
    {
        Auth::loginUsingId($id);

        return redirect()->route('home');
    }
}
