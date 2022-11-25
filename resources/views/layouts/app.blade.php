<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/main.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div id="toTopBtn">
        <img width="20px" height="20px" src="/storage/up-arrow.svg" alt="В начало">
    </div>

    <div class="min-h-screen flex flex-col">

        <!-- Page Heading -->
        <header>
            @include('layouts.navigation')
        </header>
        <!-- Page Content -->
        <main class="grow flex flex-col mx-72">
            <div class="grow max-w-6xl sm:px-6 lg:px-8 bg-gray-100">
                {{ $slot }}
            </div>
        </main>

        <footer class="bg-gray-100">
            <div class="bg-gray-100 flex max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grow" id="copyright">sai-test-lab&copy;</div>
                <nav class="self-end flex">
                    <div class="mx-2"><a href="/about" class="nav-link">О проекте</a></div>
                    <div class="mx-2"><a href="/contacts" class="nav-link">Контакты</a></div>
                </nav>
            </div>
        </footer>
    </div>
</body>
</html>
