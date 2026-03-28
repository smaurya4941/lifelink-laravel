<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LifeLink</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=sora:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --ll-bg-a: #fff7ed;
            --ll-bg-b: #f0f9ff;
            --ll-accent: #dc2626;
            --ll-accent-dark: #991b1b;
            --ll-ink: #111827;
            --ll-muted: #4b5563;
        }

        body {
            font-family: "Sora", sans-serif;
            color: var(--ll-ink);
            background:
                radial-gradient(circle at 10% 5%, rgba(220, 38, 38, 0.16), transparent 40%),
                radial-gradient(circle at 95% 20%, rgba(14, 165, 233, 0.14), transparent 45%),
                linear-gradient(140deg, var(--ll-bg-a), var(--ll-bg-b));
        }

        .mesh {
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.4) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.4) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .btn-primary {
            background: linear-gradient(120deg, var(--ll-accent), #ef4444);
            color: #fff;
            box-shadow: 0 12px 30px rgba(220, 38, 38, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(120deg, #b91c1c, #dc2626);
        }

        .role-btn.active {
            background: #111827;
            color: #fff;
            border-color: #111827;
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 500ms ease, transform 500ms ease;
        }

        .reveal.show {
            opacity: 1;
            transform: translateY(0);
        }

        .orb {
            animation: drift 6s ease-in-out infinite;
        }

        @keyframes drift {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="antialiased">
    <header class="sticky top-0 z-30 border-b border-white/60 bg-white/70 backdrop-blur">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="/" class="text-2xl font-extrabold tracking-tight text-red-600">LifeLink</a>
            <nav class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-white">Login</a>
                <a href="{{ route('register') }}" class="btn-primary rounded-lg px-4 py-2 text-sm font-semibold">Sign Up</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="mesh">
            <div class="mx-auto grid w-full max-w-7xl grid-cols-1 gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:items-center lg:py-24 lg:px-8">
                <div class="reveal">
                    <p class="mb-4 inline-flex rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-red-700">Emergency Response Layer</p>
                    <h1 class="text-4xl font-extrabold leading-tight text-slate-900 sm:text-5xl">From blood request to donor confirmation in minutes, not hours.</h1>
                    <p class="mt-6 max-w-xl text-lg leading-8 text-slate-600">LifeLink prioritizes urgent requests, scores donor compatibility, and helps hospitals, recipients, and donors coordinate faster through one platform.</p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="btn-primary rounded-lg px-6 py-3 font-semibold">Create Account</a>
                        <a href="{{ route('login') }}" class="rounded-lg border border-slate-300 bg-white px-6 py-3 font-semibold text-slate-700 hover:border-slate-400">Open Dashboard</a>
                    </div>

                    <div class="mt-8 rounded-2xl border border-slate-200 bg-white/85 p-4 shadow-sm">
                        <p class="text-sm font-semibold text-slate-900">View by role</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button" class="role-btn active rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold" data-role-btn="donor">Donor</button>
                            <button type="button" class="role-btn rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold" data-role-btn="recipient">Recipient</button>
                            <button type="button" class="role-btn rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold" data-role-btn="hospital">Hospital</button>
                        </div>
                        <div class="mt-4 rounded-lg bg-slate-900 p-4 text-slate-100">
                            <p class="text-sm font-semibold" id="roleTitle">Donor Workflow</p>
                            <p class="mt-1 text-sm text-slate-300" id="roleText">Receive ranked requests, accept quickly, and track confirmed donations with clear status updates.</p>
                        </div>
                    </div>
                </div>

                <div class="reveal">
                    <div class="relative rounded-3xl border border-white/70 bg-white/80 p-6 shadow-2xl backdrop-blur">
                        <div class="orb absolute -right-4 -top-4 h-14 w-14 rounded-full bg-red-200/70"></div>
                        <div class="orb absolute -bottom-4 -left-4 h-16 w-16 rounded-full bg-sky-200/70" style="animation-delay: 1.5s;"></div>

                        <h2 class="text-xl font-extrabold text-slate-900">Live Match Simulator</h2>
                        <p class="mt-1 text-sm text-slate-600">Adjust urgency and search radius to preview matching behavior.</p>

                        <div class="mt-5 space-y-4">
                            <label class="block text-sm font-semibold text-slate-700">
                                Urgency
                                <input id="urgency" type="range" min="1" max="4" value="3" class="mt-2 w-full">
                                <span id="urgencyLabel" class="mt-1 block text-xs text-slate-500">High</span>
                            </label>

                            <label class="block text-sm font-semibold text-slate-700">
                                Radius (km)
                                <input id="radius" type="range" min="5" max="120" value="40" class="mt-2 w-full">
                                <span id="radiusLabel" class="mt-1 block text-xs text-slate-500">40 km</span>
                            </label>

                            <label class="block text-sm font-semibold text-slate-700">
                                Blood Group
                                <select id="bloodGroup" class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                                    <option>A+</option>
                                    <option>A-</option>
                                    <option>B+</option>
                                    <option>B-</option>
                                    <option>AB+</option>
                                    <option>AB-</option>
                                    <option>O+</option>
                                    <option>O-</option>
                                </select>
                            </label>
                        </div>

                        <div class="mt-6 grid grid-cols-3 gap-3">
                            <div class="rounded-xl bg-slate-900 p-3 text-center text-white">
                                <p class="text-xs uppercase tracking-wide text-slate-300">Match Score</p>
                                <p id="simScore" class="mt-1 text-xl font-extrabold">86%</p>
                            </div>
                            <div class="rounded-xl bg-red-600 p-3 text-center text-white">
                                <p class="text-xs uppercase tracking-wide text-red-100">ETA</p>
                                <p id="simEta" class="mt-1 text-xl font-extrabold">12m</p>
                            </div>
                            <div class="rounded-xl bg-sky-600 p-3 text-center text-white">
                                <p class="text-xs uppercase tracking-wide text-sky-100">Donors</p>
                                <p id="simDonors" class="mt-1 text-xl font-extrabold">18</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="reveal text-center text-3xl font-extrabold text-slate-900">How LifeLink Works</h2>
                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <article class="reveal rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-bold uppercase tracking-wider text-red-700">Step 01</p>
                        <h3 class="mt-2 text-xl font-bold text-slate-900">Register</h3>
                        <p class="mt-2 text-sm text-slate-600">Create your account as donor, recipient, or hospital and complete profile details.</p>
                    </article>
                    <article class="reveal rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" style="transition-delay: 80ms;">
                        <p class="text-sm font-bold uppercase tracking-wider text-red-700">Step 02</p>
                        <h3 class="mt-2 text-xl font-bold text-slate-900">Match</h3>
                        <p class="mt-2 text-sm text-slate-600">Requests are ranked by compatibility, urgency, and availability signals.</p>
                    </article>
                    <article class="reveal rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" style="transition-delay: 160ms;">
                        <p class="text-sm font-bold uppercase tracking-wider text-red-700">Step 03</p>
                        <h3 class="mt-2 text-xl font-bold text-slate-900">Coordinate</h3>
                        <p class="mt-2 text-sm text-slate-600">Confirm donors and track outcomes across the full donation lifecycle.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-slate-950 py-14 text-white">
            <div class="mx-auto grid w-full max-w-6xl grid-cols-2 gap-8 px-4 text-center sm:grid-cols-4 sm:px-6 lg:px-8">
                <div class="reveal">
                    <p class="counter text-3xl font-extrabold" data-target="1200">0</p>
                    <p class="mt-1 text-sm text-slate-300">Lives Impacted</p>
                </div>
                <div class="reveal" style="transition-delay: 60ms;">
                    <p class="counter text-3xl font-extrabold" data-target="680">0</p>
                    <p class="mt-1 text-sm text-slate-300">Active Donors</p>
                </div>
                <div class="reveal" style="transition-delay: 120ms;">
                    <p class="counter text-3xl font-extrabold" data-target="240">0</p>
                    <p class="mt-1 text-sm text-slate-300">Partner Hospitals</p>
                </div>
                <div class="reveal" style="transition-delay: 180ms;">
                    <p class="counter text-3xl font-extrabold" data-target="97">0</p>
                    <p class="mt-1 text-sm text-slate-300">Match Accuracy</p>
                </div>
            </div>
        </section>

        <section class="py-16">
            <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">
                <h2 class="reveal text-center text-3xl font-extrabold text-slate-900">Frequently Asked Questions</h2>
                <div class="mt-8 space-y-3">
                    <div class="reveal rounded-xl border border-slate-200 bg-white p-4">
                        <button class="flex w-full items-center justify-between text-left font-semibold" data-accordion>
                            Is this only for emergency use?
                            <span class="text-slate-500">+</span>
                        </button>
                        <p class="mt-2 hidden text-sm text-slate-600">LifeLink supports both emergency and planned donations, while prioritizing urgent requests in matching.</p>
                    </div>
                    <div class="reveal rounded-xl border border-slate-200 bg-white p-4">
                        <button class="flex w-full items-center justify-between text-left font-semibold" data-accordion>
                            Can hospitals create and track requests?
                            <span class="text-slate-500">+</span>
                        </button>
                        <p class="mt-2 hidden text-sm text-slate-600">Yes. Hospital role support is enabled and dashboard workflows can be expanded for advanced operations.</p>
                    </div>
                    <div class="reveal rounded-xl border border-slate-200 bg-white p-4">
                        <button class="flex w-full items-center justify-between text-left font-semibold" data-accordion>
                            How is donor matching ranked?
                            <span class="text-slate-500">+</span>
                        </button>
                        <p class="mt-2 hidden text-sm text-slate-600">Matching combines blood compatibility, urgency, location proximity, temporal eligibility, and reliability factors.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/50 bg-white/70 py-6">
        <div class="mx-auto w-full max-w-7xl px-4 text-center text-sm text-slate-600 sm:px-6 lg:px-8">
            Copyright {{ date('Y') }} LifeLink. Saving lives one donation at a time.
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleContent = {
                donor: {
                    title: 'Donor Workflow',
                    text: 'Receive ranked requests, accept quickly, and track confirmed donations with clear status updates.'
                },
                recipient: {
                    title: 'Recipient Workflow',
                    text: 'Create urgent blood requests, view ranked matches, and confirm donors with transparent progress.'
                },
                hospital: {
                    title: 'Hospital Workflow',
                    text: 'Coordinate verified requests, monitor active cases, and streamline response during peak demand.'
                }
            };

            const roleButtons = document.querySelectorAll('[data-role-btn]');
            const roleTitle = document.getElementById('roleTitle');
            const roleText = document.getElementById('roleText');

            roleButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    roleButtons.forEach((b) => b.classList.remove('active'));
                    btn.classList.add('active');
                    const role = btn.getAttribute('data-role-btn');
                    roleTitle.textContent = roleContent[role].title;
                    roleText.textContent = roleContent[role].text;
                });
            });

            const urgencyInput = document.getElementById('urgency');
            const radiusInput = document.getElementById('radius');
            const bloodGroupSelect = document.getElementById('bloodGroup');
            const urgencyLabel = document.getElementById('urgencyLabel');
            const radiusLabel = document.getElementById('radiusLabel');
            const simScore = document.getElementById('simScore');
            const simEta = document.getElementById('simEta');
            const simDonors = document.getElementById('simDonors');

            const urgencyMap = {
                1: { label: 'Low', eta: 24 },
                2: { label: 'Medium', eta: 18 },
                3: { label: 'High', eta: 12 },
                4: { label: 'Critical', eta: 8 }
            };

            function updateSimulator() {
                const urgency = Number(urgencyInput.value);
                const radius = Number(radiusInput.value);
                const group = bloodGroupSelect.value;

                urgencyLabel.textContent = urgencyMap[urgency].label;
                radiusLabel.textContent = radius + ' km';

                const groupBoost = group.includes('-') ? 5 : 0;
                const score = Math.max(60, Math.min(98, 72 + (urgency * 4) + groupBoost - Math.floor(radius / 20)));
                const eta = Math.max(5, urgencyMap[urgency].eta + Math.floor(radius / 30));
                const donors = Math.max(3, Math.round((140 - radius) / 6) + urgency * 2 + (group === 'O-' ? 2 : 0));

                simScore.textContent = score + '%';
                simEta.textContent = eta + 'm';
                simDonors.textContent = String(donors);
            }

            [urgencyInput, radiusInput, bloodGroupSelect].forEach((el) => {
                el.addEventListener('input', updateSimulator);
            });

            updateSimulator();

            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                    }
                });
            }, { threshold: 0.18 });

            document.querySelectorAll('.reveal').forEach((item) => revealObserver.observe(item));

            const counterObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    const counter = entry.target;
                    const target = Number(counter.getAttribute('data-target'));
                    let current = 0;
                    const step = Math.max(1, Math.ceil(target / 60));

                    const timer = setInterval(() => {
                        current += step;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }

                        counter.textContent = current + (target === 97 ? '%' : '+');
                    }, 18);

                    observer.unobserve(counter);
                });
            }, { threshold: 0.5 });

            document.querySelectorAll('.counter').forEach((counter) => counterObserver.observe(counter));

            document.querySelectorAll('[data-accordion]').forEach((button) => {
                button.addEventListener('click', () => {
                    const content = button.nextElementSibling;
                    const icon = button.querySelector('span');
                    const isHidden = content.classList.contains('hidden');

                    content.classList.toggle('hidden');
                    icon.textContent = isHidden ? '-' : '+';
                });
            });
        });
    </script>
</body>
</html>
