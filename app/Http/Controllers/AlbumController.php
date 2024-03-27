<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman Album saya
     *
     * @return void
     */
    public function index()
    {
        $private = Foto::query()
            ->whereuser_id(Auth::user()->id)
            ->wherevisibility('private')
            ->first();

        $albums = Album::query()
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('my-album', compact('albums', 'private'));
    }

    /**
     * Fungsi untuk menampilkan halaman detail album
     *
     * @param  mixed $album
     * @return void
     */
    public function detail(Album $album)
    {
        $user = Auth::user();

        if (!$user->hasManyAlbums->contains($album)) {
            return back()->wiht('warning', 'Anda tidak memiliki izin');
        }

        return view('album-detail', compact('album'));
    }

    /**
     * Fungsi untuk menghandle upload album
     *
     * @param  mixed $request
     * @return void
     */
    public function upload(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:albums,title',
            'description' => 'required|string',
        ]);

        $data = [
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ];

        Album::create($data);

        return redirect()->route('my-album')->with('success', 'Berhasil menambah album');
    }

    /**
     * Fungsi untuk menghandle update album
     *
     * @param  mixed $request
     * @param  mixed $album
     * @return void
     */
    public function update(Request $request, Album $album)
    {
        $request->validate([
            'title' => 'required|string|unique:albums,title,' . $album->id,
            'description' => 'required|string',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description
        ];

        $album->update($data);
        $album->save();

        return redirect()->route('my-album')->with('success', 'Berhasil update data');
    }

    /**
     * Fungsi untuk menampilkan halaman create album
     *
     * @return void
     */
    public function create()
    {
        return view('form-album');
    }

    /**
     * Fungsi untuk menampilkan halaman edit album
     *
     * @param  mixed $album
     * @return void
     */
    public function edit(Album $album)
    {
        return view('form-album', compact('album'));
    }

    /**
     * Fungsi untuk menghandle delete data album
     *
     * @param  mixed $album
     * @return void
     */
    public function delete(Album $album)
    {
        $album->delete();

        return response()->json([
            'success' => true,
            'message' => 'Album berhasil dihapus'
        ]);
    }

    /**
     * Fungsi untuk menampilkan halaman private-album
     *
     * @return void
     */
    public function private()
    {
        $private_photos = Auth::user()->privatePhotos()->get();

        return view('album-detail', compact('private_photos'));
    }

    /**
     * Fungsi untuk menambahkan foto pada satu atau beberapa album
     *
     * @return void
     */
    public function addToAlbum(Request $request, Foto $photo)
    {
        $albums = $request->album_id;
        $photo->albums()->attach($albums);

        return back()->with('success', 'Berhasil menambahkan foto ke album');
    }

    /**
     * Fungsi untuk menghapus foto dari suatu album
     *
     * @param  mixed $photo
     * @param  mixed $album
     * @return void
     */
    public function deleteFromAlbum(Foto $photo, Album $album)
    {
        $photo->albums()->detach($album->id);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus foto dari album'
        ]);
    }
}
