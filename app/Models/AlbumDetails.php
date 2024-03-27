<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumDetails extends Model
{
    use HasFactory;

    /**
     * Kecualikan atribut "id" dari mass assignment atau pengisian massal.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Relasi belongs to one ke table users
     *
     * @return void
     */
    public function belongsToUser()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi belongs to one ke table fotos
     *
     * @return void
     */
    public function belongsToFoto()
    {
        return $this->belongsTo(Foto::class);
    }

    /**
     * Relasi belongs to one ke table albums
     *
     * @return void
     */
    public function belongsToAlbum()
    {
        return $this->belongsTo(Album::class);
    }
}
