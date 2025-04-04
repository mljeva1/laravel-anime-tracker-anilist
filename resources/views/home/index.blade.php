@extends('layouts.app')

@section('title', 'Anime tracker')

@section('content')
<style>
    .anime-section {
        width: 90%;
        margin: 0 auto;
        transform: translateZ(0);
        will-change: transform;
        backface-visibility: hidden;
    }
    .anime-card {
        width: 200px;
        flex-shrink: 0;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        contain: content;
        content-visibility: auto;
    }
    .anime-image {
        width: auto;
        height: 300px;
        object-fit: contain;
    }
    .image-anime {
        width: 90%;
        align-self: center;
    }
    @media (max-width: 768px) {
        .anime-section {
            width: 100%;
        }
        .anime-card {
            width: 150px;
        }
        .anime-image {
            height: 225px;
        }
        .image-anime {
        width: 100%;
        align-self: center;
    }
    }
    .content-toggle {
        background: rgba(74, 38, 67, 0.4);
        border-radius: 26px;
        padding: 5px;
        display: inline-flex;
        margin-bottom: 20px;
    }
    .content-toggle .btn {
        border-radius: 20px;
        color: #e6e3e8;
        border: none;
        padding: 8px 20px;
    }
    .content-toggle .btn.active {
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="mb-3 mt-5" data-bs-smooth-scroll="true">
    <div class="d-flex flex-column justify-content-center">
        @guest
        <div class="text-center align-middle mt-3 p-3 image-anime" 
            style="color:#e6e3e8 !important; background: rgba(74, 38, 67, 0.4); border-radius: 26px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);">
            <h2>Dobrodošli u sustav anime svijeta!</h2>
            <p>Prijavite se kako bi vidjeli sučelje</p>
        </div>
        @else
        <div style="color:#e6e3e8 !important; background: rgba(74, 38, 67, 0.4); border-radius: 26px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);
            border: 3px solid rgba(255, 255, 255, 0.4);" class="d-flex flex-row p-0 m-0 justify-content-center image-anime">
            <h2 class="p-3 m-0">Dobrodošao<span style="color: #f5dad3;"> {{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                alt="Avatar" class="rounded-circle" 
                style="width: 50px; height: 50px; object-fit: cover; border: 3px solid rgba(255, 255, 255, 0.3);">
            </h2>
        </div>
        @endguest

        <!-- Content Toggle Buttons -->
        <div class="d-flex justify-content-center m-0 mt-4">
            <div class="content-toggle">
                <button class="btn active" id="anime-toggle">Anime</button>
                <button class="btn" id="manga-toggle">Manga</button>
            </div>
        </div>

        <!-- Anime Content -->
        <div id="anime-content">
            <!-- Trending Anime Section -->
            <div class="mt-4 p-3 anime-section"
                style="color:#e6e3e8 !important; background: rgba(74, 38, 67, 0.4);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); border: 3px solid rgba(255, 255, 255, 0.4);">
                <h2 style="color:#e6e3e8; margin-left: 10px;">Trending anime</h2>
                
                <div style="overflow-x: auto; white-space: nowrap; scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                    <div style="display: inline-flex; gap: 25px; padding: 0 10px;">
                        @foreach ($topAnimehome as $index => $topAnime)
                            <div class="anime-card">
                                <img src="{{ $topAnime['coverImage']['large'] }}" 
                                    class="anime-image lazy">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(74, 38, 67, 0.8); 
                                        padding: 8px; color: white; font-size: 14px;">
                                    <div style="font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $index + 1 }}. {{ $topAnime['title']['english'] ?? $topAnime['title']['userPreferred'] }}
                                    </div>
                                    <div style="font-size: 12px; margin-top: 4px;">
                                        {{ $topAnime['title']['native'] }}
                                    </div>
                                    <div style="font-size: 12px; margin-top: 4px;">
                                        {{ $topAnime['averageScore']/10 }}/10 • {{ $topAnime['episodes'] }} ep
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Upcoming Anime Section -->
            <div class="mt-4 p-3 anime-section"
                style="color:#e6e3e8 !important; background: rgba(74, 38, 67, 0.4);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); border: 3px solid rgba(255, 255, 255, 0.4);">
                <h2 style="color:#e6e3e8; margin-left: 10px;">Nadolazeći anime</h2>
                
                <div style="overflow-x: auto; white-space: nowrap; scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                    <div style="display: inline-flex; gap: 25px; padding: 0 10px;">
                        @foreach ($topUpcome as $index => $topAnime)
                            <div class="anime-card">
                                <img src="{{ $topAnime['coverImage']['large'] }}" 
                                    class="anime-image">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(74, 38, 67, 0.8); 
                                        padding: 8px; color: white; font-size: 14px;">
                                    <div style="font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $index + 1 }}. {{ $topAnime['title']['english'] ?? $topAnime['title']['userPreferred'] }}
                                    </div>
                                    <div style="font-size: 12px; margin-top: 4px;">
                                        {{ $topAnime['title']['native'] }}
                                    </div>
                                    <div style="font-size: 12px; margin-top: 4px;">
                                        {{ $topAnime['startDate']['month'] }} / {{ $topAnime['startDate']['year'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Manga Content (initially hidden) -->
        <div id="manga-content" style="display: none;">
            <!-- Top 10 Manga Section -->
            <div class="mt-4 p-3 anime-section"
                style="color:#e6e3e8 !important; background: rgba(74, 38, 67, 0.4);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); border: 3px solid rgba(255, 255, 255, 0.4);">
                <h2 style="color:#e6e3e8; margin-left: 10px;">Trending manga</h2>
                
                <div style="overflow-x: auto; white-space: nowrap; scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                    <div style="display: inline-flex; gap: 25px; padding: 0 10px;">
                        @foreach ($topManga as $index => $topMangas)
                            <div class="anime-card">
                                <img src="{{ $topMangas['coverImage']['large'] }}" 
                                    class="anime-image">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(74, 38, 67, 0.8); 
                                        padding: 8px; color: white; font-size: 14px;">
                                    <div style="font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $index + 1 }}. {{ $topMangas['title']['english'] ?? $topMangas['title']['userPreferred'] }}
                                    </div>
                                    <div style="font-size: 12px; margin-top: 4px;">
                                        {{ $topMangas['title']['native'] }}
                                    </div>
                                    <div style="font-size: 12px; margin-top: 4px;">
                                        {{ $topMangas['averageScore']/10 }}/10 • {{ $topMangas['chapters'] }} chapters
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top 10 Upcoming Manga Section -->
            <div class="mt-4 p-3 anime-section"
                style="color:#e6e3e8 !important; background: rgba(74, 38, 67, 0.4);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); border: 3px solid rgba(255, 255, 255, 0.4);">
                <h2 style="color:#e6e3e8; margin-left: 10px;">Nadolazeća manga</h2>
                
                <div style="overflow-x: auto; white-space: nowrap; scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                    <div style="display: inline-flex; gap: 25px; padding: 0 10px;">
                        @foreach ($upcomingManga as $index => $upcome)
                            <div class="anime-card">
                                <img src="{{ $upcome['coverImage']['large'] }}" 
                                    class="anime-image" >
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(74, 38, 67, 0.8); 
                                        padding: 8px; color: white; font-size: 14px;">
                                    <div style="font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $index + 1 }}. {{ $upcome['title']['english'] ?? $upcome['title']['userPreferred'] }}
                                    </div>
                                    <div style="font-size: 12px; margin-top: 4px;">
                                        {{ $upcome['title']['native'] }}
                                    </div>
                                    <div style="font-size: 12px; margin-top: 4px;">
                                        {{ $upcome['startDate']['month'] }} / {{ $upcome['startDate']['year'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const animeToggle = document.getElementById('anime-toggle');
    const mangaToggle = document.getElementById('manga-toggle');
    const animeContent = document.getElementById('anime-content');
    const mangaContent = document.getElementById('manga-content');
    
    animeToggle.addEventListener('click', function() {
        animeToggle.classList.add('active');
        mangaToggle.classList.remove('active');
        animeContent.style.display = 'block';
        mangaContent.style.display = 'none';
    });
    
    mangaToggle.addEventListener('click', function() {
        mangaToggle.classList.add('active');
        animeToggle.classList.remove('active');
        mangaContent.style.display = 'block';
        animeContent.style.display = 'none';
    });
});
</script>
@endsection
