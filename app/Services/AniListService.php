<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AniListService
{
    public string $endpoint = 'https://graphql.anilist.co';

    /**
     * Dohvati sve podatke za početnu stranicu u jednom API pozivu
     */
    public function getHomePageData()
    {
        return Cache::remember('home_page_data', 3600, function () {
            $query = '
            query {
                trendingAnime: Page(page: 1, perPage: 10) {
                    media(type: ANIME, sort: TRENDING_DESC, status: FINISHED) {
                        title {
                            english
                            native
                            userPreferred
                        }
                        averageScore
                        coverImage {
                            large
                        }
                        episodes
                        studios(sort: FAVOURITES_DESC, isMain: true) {
                            nodes {
                                name
                            }
                        }
                    }
                }
                upcomingAnime: Page(page: 1, perPage: 10) {
                    media(type: ANIME, sort: FAVOURITES_DESC, status: NOT_YET_RELEASED) {
                        title {
                            english
                            native
                            userPreferred
                        }
                        startDate {
                            month
                            year
                        }
                        coverImage {
                            large
                        }
                    }
                }
                trendingManga: Page(page: 1, perPage: 10) {
                    media(type: MANGA, sort: TRENDING_DESC, status: FINISHED) {
                        title {
                            english
                            native
                            userPreferred
                        }
                        averageScore
                        coverImage {
                            large
                        }
                        chapters
                    }
                }
                upcomingManga: Page(page: 1, perPage: 10) {
                    media(type: MANGA, sort: TRENDING_DESC, status: NOT_YET_RELEASED, startDate_greater: 20250000) {
                        title {
                            english
                            native
                            userPreferred
                        }
                        startDate {
                            month
                            year
                        }
                        coverImage {
                            large
                        }
                        chapters
                    }
                }
            }';
            
            $response = Http::post($this->endpoint, [
                'query' => $query
            ]);
        
            return $response->json();
        });
    }

    public function userAvatar($characterId)
    {
        return Cache::remember('character_'.$characterId, 86400, function () use ($characterId) {
            $query = '
            query ($characterId: Int) {
                Character(id: $characterId) {
                    image {
                        medium
                        large
                    }
                    name {
                        full
                    }
                }
            }';

            $response = Http::post($this->endpoint, [
                'query' => $query,
                'variables' => [
                    'characterId' => $characterId,
                ],
            ]);

            return $response->json();
        });
    }

    // Zadržane originalne metode za kompatibilnost
    public function topAnimeHome() 
    {
        $data = $this->getHomePageData();
        return [
            'data' => [
                'Page' => [
                    'media' => $data['data']['trendingAnime']['media'] ?? []
                ]
            ]
        ];
    }
    
    public function topUpcome() 
    {
        $data = $this->getHomePageData();
        return [
            'data' => [
                'Page' => [
                    'media' => $data['data']['upcomingAnime']['media'] ?? []
                ]
            ]
        ];
    }
    
    public function topMangaHome() 
    {
        $data = $this->getHomePageData();
        return [
            'data' => [
                'Page' => [
                    'media' => $data['data']['trendingManga']['media'] ?? []
                ]
            ]
        ];
    }
    
    public function upcomingManga()
    {
        $data = $this->getHomePageData();
        return [
            'data' => [
                'Page' => [
                    'media' => $data['data']['upcomingManga']['media'] ?? []
                ]
            ]
        ];
    }

    /**
     * Anime stranica - pregled, dodavanje u kolekciju i pretraga
     */
    public function homeAnimes($genre = null, $sort = null, $perPage = 10)
    {
        $genreFilter = $genre ? ', genre_in: ["' . $genre . '"]' : '';
        $orderBy = $sort ? ', sort: ' . $sort : '';
        
        $query = '
            query {
                homeAnime: Page(page: 1, perPage: ' . $perPage . ') {
                    media(type: ANIME' . $orderBy . ',status: FINISHED, isLicensed: true, format: TV' . $genreFilter . ') {
                        id
                        idMal
                        coverImage {
                            large
                        }
                        title {
                            english
                            native
                            userPreferred
                        }
                        averageScore
                        episodes
                        favourites
                        format
                        genres
                    }
                }
                GenreCollection
            }';

        $response = Http::post($this->endpoint, [
            'query' => $query
        ]);

        return $response->json();
    }

}