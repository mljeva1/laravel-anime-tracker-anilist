<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Genre;
use App\Services\AniListService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\LazyCollection;

class AnimeController extends Controller
{
    protected $aniListService;

    public function __construct(AniListService $aniListService)
    {
        $this->aniListService = $aniListService;
    }

    /**
     * Prikaži početnu stranicu s top anime serijama
     */
    public function index(Request $request) {
        $selectedGenre = $request->input('genre');
        $selectedSort = $request->input('sort');
        $perPage = $request->input('per_page', 10); // Default 10
        
        // Ograniči maksimalan broj stavki po stranici
        $perPage = min($perPage, 25);
        
        $data = $this->aniListService->homeAnimes($selectedGenre, $selectedSort, $perPage);
        
        $animeHome = collect($data['data']['homeAnime']['media'] ?? [])
            ->lazy()
            ->take($perPage)
            ->all();
        
        // Dohvati listu svih žanrova
        $genres = $data['data']['GenreCollection'] ?? [
            "Action", "Adventure", "Comedy", "Drama", "Ecchi", "Fantasy", 
            "Hentai", "Horror", "Mahou Shoujo", "Mecha", "Music", "Mystery", 
            "Psychological", "Romance", "Sci-Fi", "Slice of Life", "Sports", 
            "Supernatural", "Thriller"
        ];
        // Ručno definiraj dostupne sortove
        $sorts = ['POPULARITY_DESC' => 'Popularnost', 'TRENDING_DESC' => 'U trendu', 
        'SCORE_DESC' => 'Ocjena viša', 'FAVOURITES_DESC' => 'Najbolje ocjenjeni', 'TITLE_ENGLISH' => 'A-Ž', 'TITLE_ENGLISH_DESC' => 'Ž-A'];
        
        return view('anime.index', compact('animeHome', 'genres', 'sorts', 'perPage'));
    }    
    

    public function topAnimeHome()
    {
        $response = $this->aniListService->topAnimeHome();
        
        // Koristi LazyCollection umjesto obične kolekcije
        $topAnimehome = LazyCollection::make($response['data']['Page']['media'] ?? [])
            ->take(10)
            ->all();
        
        // Isto za ostale kolekcije
        $responseUpcome = $this->aniListService->topUpcome();
        $topUpcome = LazyCollection::make($responseUpcome['data']['Page']['media'] ?? [])
            ->take(10)
            ->all();
            
        // Slično za topManga i upcomingManga
        $responseManga = $this->aniListService->topMangaHome();
        $topManga = LazyCollection::make($responseManga['data']['Page']['media'] ?? [])
            ->take(10)
            ->all();
    
        $responseUpManga = $this->aniListService->upcomingManga();
        $upcomingManga = LazyCollection::make($responseUpManga['data']['Page']['media'] ?? [])
            ->take(10)
            ->all();
        
        return view('home.index', compact('topAnimehome', 'topUpcome', 'topManga', 'upcomingManga'));
    }


}