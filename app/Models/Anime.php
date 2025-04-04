<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    //
    protected $fillable = [
        'mal_id', 
        'title', 
        'english_title', 
        'japanese_title', 
        'image_url', 
        'thumbnail_url', 
        'episodes', 
        'status', 
        'type', 
        'synopsis', 
        'score', 
        'aired_from', 
        'aired_to',
        'season', 
        'season_year'
    ];

    protected $casts = [
        'aired_from' => 'datetime',
        'aired_to' => 'datetime',
    ];

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_anime')
            ->withPivot('watch_status', 'episodes_watched', 'rating', 'notes')
            ->withTimestamps();
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'anime_genres');
    }
}
