<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Fungsi untuk download foto
     *
     * @param  mixed $photo
     * @return void
     */
    public function download(Foto $photo)
    {
        $file_path = public_path("storage/$photo->file_path");

        if (file_exists($file_path)) {
            $response = response()->download($file_path);

            $photo->incrementDownloads();

            return $response;
        } else {
            return response()->with('warning', 'Foto tidak ditemukan');
        }
    }
}
