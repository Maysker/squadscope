<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Squad Scope</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-links a {
            color: white; /* Устанавливаем цвет текста белым */
        }
    </style>
</head>
<body class="antialiased font-sans">
    <div style="position: relative; height: 100vh;">
        <iframe src="https://my.spline.design/neoninfusedretroelectrowithjawanimation-e3b995aa4b8ac86d8a2b04ae8c5241c2/" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"></iframe>
        <div style="position: absolute; top: 0; left: 0; width: 100%; padding: 20px; z-index: 10;">
            <header class="text-right auth-links">
                @if (Route::has('login'))
                    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm underline">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm underline">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm underline">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </header>
        </div>
    </div>
</body>
</html>