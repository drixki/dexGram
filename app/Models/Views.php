<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    use HasFactory;

    /**
     * Kecualikan atribut "id" dari mass assignment atau pengisian massal.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'views';

    /**
     * Relasi belongs to one ke table foto
     *
     * @return void
     */
    public function belongsToFoto()
    {
        return $this->belongsTo(Foto::class, 'foto_id');
    }
}
