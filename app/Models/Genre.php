<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    //
    protected $fillable = ['name'];

    public function animes()
    {
        return $this->belongsToMany(Anime::class, 'anime_genres');
    }
}
