@extends('layouts.app')

@section('content')
<style>
.card-img-overlay-new {
    position: absolute;
    /* top: 0; */
    right: 0;
    bottom: 0;
    left: 0;
    padding: var(--bs-card-img-overlay-padding);
    border-radius: var(--bs-card-inner-border-radius);
}
</style>
<div class="container">
    <h1 class="col text-center mt-3 p-3" style="color:#e6e3e8 !important; background: rgba(74, 38, 67, 0.4); border-radius: 26px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);
            border: 3px solid rgba(255, 255, 255, 0.4);">
        <img src="image/anime-logo.jpg" style="width: 70px; height: 70px; object-fit: cover; border: 3px solid rgba(255, 255, 255, 0.3); 
        border-radius:50%;">
        Svi anime</h1>

        <!-- Filter forma -->
        <div class="container mt-3 mb-3 p-2"
        style="color:#e6e3e8 !important; background: rgba(74, 38, 67, 0.4); border-radius: 26px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);
            border: 3px solid rgba(255, 255, 255, 0.4);">
            
            <div class="d-flex flex-md-row flex-wrap flex-column justify-content-center">
                <label for="genreSelect" class="p-2 form-label fw-bold mb-1">Po žanru:</label>
                <div class="d-flex flex-md-row flex-wrap flex-column">

                    <select class="m-1 form-select form-select-sm" id="genreSelect" style="width: auto; min-width: 150px; background:rgba(123, 89, 150, 0.6); color: #f5dad3;">
                        <option value="" {{ !request('genre') ? 'selected' : '' }}><span>Svi žanrovi</span></option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                {{ $genre }}
                            </option>
                        @endforeach
                    </select>
                <label for="sortSelect" class="p-2 form-label fw-bold mb-1">Rasporedi:</label>
                <select class="m-1 form-select form-select-sm" id="sortSelect" style="width: auto; min-width: 150px; background:rgba(123, 89, 150, 0.6);color: #f5dad3;">
                    <option value="" {{ !request('sort') ? 'selected' : '' }}>&nbsp;--Odaberi--</option>
                    @foreach($sorts as $value => $label)
                        <option value="{{ $value }}" {{ request('sort') == $value  ? 'selected' : '' }}>
                            &nbsp;{{ $label }}
                        </option>
                    @endforeach
                </select>
                <label for="perPageSelect" class="p-2 form-label fw-bold mb-1 me-2">Prikaži po stranici:</label>
                <select class="m-1 form-select form-select-sm" id="perPageSelect" style="width: auto; min-width: 80px; background:rgba(123, 89, 150, 0.6);color: #f5dad3;">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                </select>
                <a href="{{ route('anime.index') }}" class="p-1 m-1 btn btn-sm btn-outline-light" style="background:rgba(123, 89, 150, 0.6);">
                    <i class="bi bi-x-circle me-1"></i>Reset
                </a>
                </div>
            </div>
        </div>
        
        <script>
        document.getElementById('sortSelect').addEventListener('change', function() {
            const currentGenre = new URLSearchParams(window.location.search).get('genre') || '';
            window.location.href = '{{ route("anime.index") }}?sort=' + this.value + 
                                (currentGenre ? '&genre=' + currentGenre : '');
        });

        document.getElementById('genreSelect').addEventListener('change', function() {
            const currentSort = new URLSearchParams(window.location.search).get('sort') || '';
            window.location.href = '{{ route("anime.index") }}?genre=' + this.value + 
                                (currentSort ? '&sort=' + currentSort : '');
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('perPageSelect').addEventListener('change', function() {
                const currentGenre = new URLSearchParams(window.location.search).get('genre') || '';
                const currentSort = new URLSearchParams(window.location.search).get('sort') || '';
                
                let url = '{{ route("anime.index") }}?per_page=' + this.value;
                if (currentGenre) url += '&genre=' + currentGenre;
                if (currentSort) url += '&sort=' + currentSort;
                
                window.location.href = url;
            });
        });
        </script>
        

        <div class="row p-0 m-0 justify-content-between justify-content-md-between">
            @foreach ($animeHome as $anime)
                <div class="p-0 m-2 col-md-2 col-sm-6 col-5 mb-3">
                    <div class="card" style="border-radius: 26px; border: 1px solid rgba(255, 255, 255, 0.5);">
                        <img style="aspect-ratio: 0.6; border-radius: 26px; object-fit: cover; max-height: 80%;" src="{{ $anime['coverImage']['large'] }}" 
                        loading="lazy" class="card-img" alt="{{ $anime['title']['english'] ?? $anime['title']['userPreferred'] }}">
                        
                        <div class="lh-1 m-0 p-2 h-auto card-img-overlay-new rounded-top-0" 
                        style="border: none; bottom: 0; background: rgba(74, 38, 67, 0.5); border-radius: 26px; max-height: 80%;">
                            <p class="fs-6 m-0 fw-medium" style="color: #f5dad3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $anime['title']['english'] ?? $anime['title']['userPreferred'] }}</p>
                            <p class="m-1 fw-medium" style="color: #f5dad3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $anime['title']['native'] }}</p>
                            <p class="fw-bold fw-medium m-1" style="color: #f5dad3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $anime['averageScore']/10 }}/10<i class="bi bi-dot"></i>{{ $anime['episodes'] }} ep &nbsp;
                            </p>
                            <p class="m-1 fw-bold fw-medium" style="color: #f5dad3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $anime['favourites'] }}
                                <a href="#" class="fs-5" style="color: #f5dad3;">
                                    <i class="bi bi-plus-circle"></i>
                               </a>
                            </p>
                        </div>
                      </div>
                </div>
            @endforeach
        </div>
</div>

@endsection