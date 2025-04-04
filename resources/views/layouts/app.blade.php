<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .gradient-navbar {
            background: linear-gradient(90deg, rgba(2,0,36,0.8) 0%, rgba(74,38,67,0.8) 60%, rgba(135,102,150,0.8) 100%);
        }
        .navbar-nav .nav-link, .navbar-brand {
            color: #f5dad3 !important;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(245,218,211,0.75)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        body {
            background-image: url('{{ asset('image/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 0;
            margin: 0;
            overflow-x: none;
        }
        .modal-backdrop {
            z-index: 1040 !important;
        }
        .modal-content {
            z-index: 1100 !important;
        }
        html {
            scroll-behavior: smooth;
            }
    </style>    
</head>
<body data-bs-smooth-scroll="true">
    <nav class="navbar navbar-expand-lg sticky-top gradient-navbar">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand mb-0 mt-0 pe-3 fs-5 border-end">Weeb world by Amer</a>

            <!-- Toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left-aligned links -->
                <ul class="navbar-nav me-auto mb-0 mb-lg-0 text-center">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }} btn" aria-current="page" href="{{ route('home') }}">Naslovna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('anime.index') ? 'active' : '' }} btn" aria-current="page" href="{{ route('anime.index') }}">List anime</a>
                    </li>
                </ul>

                <!-- Right-aligned links -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-center">
                    @auth
                        <!-- User's name and logout button if logged in -->
                        <li class="nav-item">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                            alt="Avatar" 
                            class="rounded-circle" 
                            style="width: 40px; height: 40px; object-fit: cover; border: 3px solid rgba(255, 255, 255, 0.3);">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.user') }}">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="text-decoration: none;">Odjava</button>
                            </form>
                        </li>
                    @else
                        <!-- Login and register links if not logged in -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Prijava</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registracija</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>