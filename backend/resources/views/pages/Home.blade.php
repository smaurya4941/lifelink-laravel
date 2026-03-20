<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LifeLink</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-rose-50 via-white to-red-100 text-slate-900 antialiased">
    <header class="sticky top-0 z-20 border-b border-red-100 bg-white/90 backdrop-blur">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="/" class="text-2xl font-extrabold tracking-tight text-red-600">LifeLink</a>
            <nav class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-red-600">Login</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-700">Sign Up</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="mx-auto grid w-full max-w-7xl grid-cols-1 gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:items-center lg:py-24 lg:px-8">
            <div>
                <p class="mb-4 inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-red-700">AI-powered donor matching</p>
                <h1 class="text-4xl font-extrabold leading-tight text-slate-900 sm:text-5xl">Save lives faster with smarter blood matching.</h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-slate-600">LifeLink connects donors and recipients using compatibility, proximity, urgency, and reliability scoring so critical requests get fulfilled quicker.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="rounded-lg bg-red-600 px-6 py-3 font-semibold text-white hover:bg-red-700">Join the network</a>
                    <a href="{{ route('login') }}" class="rounded-lg border border-red-200 bg-white px-6 py-3 font-semibold text-red-700 hover:border-red-300 hover:bg-red-50">Sign in</a>
                </div>
            </div>
            <div class="rounded-2xl border border-red-100 bg-white p-6 shadow-xl shadow-red-100/70">
                <h2 class="text-lg font-bold text-slate-900">Platform Highlights</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-700">
                    <li class="rounded-lg bg-red-50 p-3">Blood-group compatibility engine with ranked match scores.</li>
                    <li class="rounded-lg bg-sky-50 p-3">Recipient request workflow with donor acceptance and confirmation.</li>
                    <li class="rounded-lg bg-emerald-50 p-3">Live analytics, map view, notifications, and security dashboard.</li>
                    <li class="rounded-lg bg-amber-50 p-3">Role-based dashboards for donors, recipients, and admins.</li>
                </ul>
            </div>
        </section>

        <section class="bg-white/80 py-16">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-center text-3xl font-extrabold text-slate-900">How LifeLink Works</h2>
                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <article class="rounded-xl border border-red-100 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-red-700">1. Register</h3>
                        <p class="mt-2 text-sm text-slate-600">Create an account as donor or recipient and complete your profile details.</p>
                    </article>
                    <article class="rounded-xl border border-red-100 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-red-700">2. Match</h3>
                        <p class="mt-2 text-sm text-slate-600">Create requests or receive match alerts generated from your eligibility and location.</p>
                    </article>
                    <article class="rounded-xl border border-red-100 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-red-700">3. Coordinate</h3>
                        <p class="mt-2 text-sm text-slate-600">Accept, confirm, and track blood donation flow from request to completion.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-red-700 py-14 text-white">
            <div class="mx-auto grid w-full max-w-6xl grid-cols-2 gap-8 px-4 text-center sm:grid-cols-4 sm:px-6 lg:px-8">
                <div>
                    <p class="text-3xl font-extrabold">1000+</p>
                    <p class="mt-1 text-sm text-red-100">Lives Impacted</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold">500+</p>
                    <p class="mt-1 text-sm text-red-100">Active Donors</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold">200+</p>
                    <p class="mt-1 text-sm text-red-100">Partner Hospitals</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold">95%</p>
                    <p class="mt-1 text-sm text-red-100">Match Accuracy</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-red-100 bg-white py-6">
        <div class="mx-auto w-full max-w-7xl px-4 text-center text-sm text-slate-600 sm:px-6 lg:px-8">
            Copyright {{ date('Y') }} LifeLink. Saving lives one donation at a time.
        </div>
    </footer>
</body>
</html>
