<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Views;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FotoController extends Controller
{
    /**
     * Fungsi untuk menampilkan detail foto
     *
     * @param  mixed $slug
     * @return void
     */
    public function view(string $slug)
    {

        $photo = Foto::query()
            ->whereSlug($slug)
            ->with('belongsToUser', 'hasManyComments')
            ->firstOrFail();

        if ($photo->visibility == 'private') {
            return back()->with('warning', 'Foto telah di privat, anda tidak memiliki akses');
        }

        $other_photos = Foto::query()
            ->whereNot('slug', $slug)
            ->inRandomOrder()
            ->with('belongsToUser')
            ->get();

        $user = Auth::user();

        $albums = $user->hasManyAlbums()->get();

        if (!$user->recentView($photo->id)) {
            $user->viewedPhotos()->attach($photo->id);
        }

        return view('view-detail-photo', compact('photo', 'other_photos', 'albums'));
    }

    /**
     * Fungsi untuk menghandle unggah foto
     *
     * @param  mixed $request
     * @return void
     */
    public function upload(Request $request)
    {
        // Validasi untuk field request yang masuk
        $request->validate([
            'title' => ['required', 'string', 'unique:fotos,title', 'max:50'],
            'description' => ['nullable', 'string', 'max:300'],
            'photo' => ['required', 'image']
        ]);

        $slug = Str::slug($request->title);

        if ($request->hasFile('photo')) {
            // menyimpan nama
            $title = $slug . '.' . $request->file('photo')->getClientOriginalExtension();
            // Mengunggah file foto ke direktori 'photos' di sistem penyimpanan publik
            $file_path = $request->photo->storeAs('photos', $title, 'public');
        }

        $data = [
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'slug' => $slug,
            'comment_permit' => $request->commentPermit ? true : false,
            'description' => $request->description ?: null,
            'file_path' => $file_path,
            'visibility' => $request->visibility
        ];

        if ($request->category) {
            $data['category_id'] = $request->category;
        }

        // Membuat entitas Foto baru dengan data yang diterima
        Foto::create($data);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('home')->with('success', 'Berhasil mengunggah foto!');
    }

    /**
     * Fungsi untuk update foto
     *
     * @param  mixed $request
     * @param  mixed $foto
     * @return void
     */
    public function update(Request $request, Foto $photo)
    {
        $request->validate([
            'title' => ['required', 'string', 'unique:fotos,title,' . $photo->id], 'max:50',
            'description' => ['nullable', 'string', 'max:300'],
            'photo' => ['nullable', 'image']
        ]);

        $slug = Str::slug($request->title);

        $data = [
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'visibility' => $request->visibility
        ];

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($photo->file_path);
            $title = $slug . '.' . $request->file('photo')->getClientOriginalExtension();
            $file_path = $request->photo->storeAs('photos', $title, 'public');
            $data['file_path'] = $file_path;
        }

        if ($request->category) {
            $data['category_id'] = $request->category;
        }

        $photo->update($data);
        $photo->save();

        return redirect()->route('my-photo')->with('success', 'Berhasil memperbarui foto');
    }

    /**
     * Fungsi untuk menghapus foto
     *
     * @param  mixed $photo
     * @return void
     */
    public function delete(Foto $photo)
    {
        Storage::disk('public')->delete($photo->file_path);

        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus'
        ]);
    }
}
