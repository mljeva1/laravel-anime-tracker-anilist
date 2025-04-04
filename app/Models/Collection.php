<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    //
    protected $fillable = [
        'user_id', 'name', 'description', 'is_private'
    ];

    /**
     * Korisnik kojem pripada kolekcija
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Anime serije u kolekciji
     */
    public function animes()
    {
        return $this->belongsToMany(Anime::class, 'collection_anime')
            ->withPivot('watch_status', 'episodes_watched', 'rating', 'notes')
            ->withTimestamps();
    }
}
