<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="ll-shell">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="px-4 pt-6 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto ll-header-card ll-fade-up">
                {{ $header }}
            </div>
        </header>

        @endisset
        @if(session('error'))
        <div class="mx-auto mt-4 max-w-7xl rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-center text-rose-700">
            {{ session('error') }}
        </div>
        @endif

        <!-- Page Content -->
        <main class="pb-10">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
