<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
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
    protected $table = 'categories';

    /**
     * Relasi has many ke table foto
     *
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Foto::class);
    }
}
