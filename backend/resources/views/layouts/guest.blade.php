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
    <body class="text-gray-900 antialiased">
        <div class="min-h-screen bg-gradient-to-br from-rose-50 via-white to-red-100 px-4 py-10">
            <div class="mx-auto w-full sm:max-w-md ll-fade-up">
                <div class="mb-6 text-center">
                    <a href="/" class="inline-flex items-center rounded-full bg-white/90 px-5 py-2 text-sm font-semibold text-rose-700 shadow">
                        LifeLink
                    </a>
                </div>

                <div class="ll-surface w-full overflow-hidden px-6 py-6 sm:px-7 sm:py-7">
                {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
