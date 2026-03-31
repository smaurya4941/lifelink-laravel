<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>LifeLink | The Vital Pulse of Lifesaving</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "tertiary-container": "#00845a",
              "secondary-container": "#d5e3fc",
              "on-surface-variant": "#5c3f40",
              "inverse-on-surface": "#eaf1ff",
              "primary-container": "#e11d48",
              "inverse-primary": "#ffb3b6",
              "surface": "#f8f9ff",
              "outline-variant": "#e5bdbe",
              "surface-container-high": "#dce9ff",
              "inverse-surface": "#213145",
              "primary-fixed": "#ffdada",
              "on-primary": "#ffffff",
              "secondary-fixed-dim": "#b9c7df",
              "secondary-fixed": "#d5e3fc",
              "surface-container-lowest": "#ffffff",
              "on-tertiary": "#ffffff",
              "on-tertiary-fixed": "#002113",
              "on-secondary-fixed-variant": "#3a485b",
              "surface-container": "#e5eeff",
              "on-tertiary-container": "#eefff3",
              "tertiary": "#006847",
              "primary-fixed-dim": "#ffb3b6",
              "secondary": "#515f74",
              "on-secondary-fixed": "#0d1c2e",
              "on-error-container": "#93000a",
              "surface-container-low": "#eff4ff",
              "error": "#ba1a1a",
              "on-tertiary-fixed-variant": "#005236",
              "on-primary-container": "#fffaf9",
              "on-primary-fixed-variant": "#920028",
              "on-background": "#0b1c30",
              "surface-variant": "#d3e4fe",
              "error-container": "#ffdad6",
              "outline": "#906f70",
              "on-primary-fixed": "#40000c",
              "surface-tint": "#be0037",
              "surface-dim": "#cbdbf5",
              "tertiary-fixed-dim": "#4edea3",
              "on-surface": "#0b1c30",
              "surface-bright": "#f8f9ff",
              "background": "#f8f9ff",
              "on-secondary": "#ffffff",
              "surface-container-highest": "#d3e4fe",
              "on-error": "#ffffff",
              "primary": "#b80035",
              "on-secondary-container": "#57657a",
              "tertiary-fixed": "#6ffbbe"
            },
            fontFamily: {
              "headline": ["Manrope"],
              "body": ["Inter"],
              "label": ["Inter"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
<style>
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      }
      .glass-nav {
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
      }
    </style>
</head>
<body class="bg-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
<nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl shadow-sm dark:shadow-none tonal-shift bg-slate-50/50 dark:bg-slate-950/50 no-border">
<div class="flex justify-between items-center px-6 py-3 max-w-full mx-auto">
<div class="text-2xl font-black tracking-tighter text-rose-700 dark:text-rose-500 font-headline">LifeLink</div>
<div class="hidden md:flex items-center space-x-8 font-manrope font-bold text-sm tracking-tight">
<a class="text-rose-700 dark:text-rose-400 font-extrabold border-b-2 border-rose-600 transition-all duration-300" href="#">Home</a>
<a class="text-slate-600 dark:text-slate-400 hover:text-rose-500 transition-all duration-300" href="#how-it-works">How it Works</a>
<a class="text-slate-600 dark:text-slate-400 hover:text-rose-500 transition-all duration-300" href="#actors">Donor/Recipient</a>
<a class="text-slate-600 dark:text-slate-400 hover:text-rose-500 transition-all duration-300" href="#hospital">Hospital</a>
</div>
<div class="flex items-center space-x-4">
<div class="flex space-x-2">
<a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-rose-600 font-bold hover:bg-rose-50 transition-all scale-95 active:opacity-80">Login</a>
<a href="{{ route('register') }}" class="px-5 py-2 rounded-lg bg-gradient-to-r from-primary to-primary-container text-white font-bold shadow-lg shadow-primary/20 scale-95 active:opacity-80 transition-all">Register</a>
</div>
</div>
</div>
</nav>
<main class="pt-20">
<section class="relative overflow-hidden px-6 py-20 lg:py-32 bg-surface-container-low" id="home">
<div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
<div class="z-10">
<span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-xs font-bold mb-6 tracking-wide">
<span class="material-symbols-outlined text-sm mr-1" style="font-variation-settings: 'FILL' 1;">emergency</span>
                        URGENT RESPONSE SYSTEM
                    </span>
<h1 class="text-5xl lg:text-7xl font-black font-headline text-on-background leading-tight mb-6 tracking-tight">
                        The Vital Pulse of <span class="text-primary italic">Lifesaving</span>
</h1>
<p class="text-lg text-on-secondary-container leading-relaxed mb-10 max-w-xl">
                        A real-time emergency coordination network bridging the gap between donors, recipients, and hospitals. Ensuring every drop counts when seconds matter most.
                    </p>
<div class="flex flex-col sm:flex-row gap-4">
<a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-br from-primary to-primary-container text-on-primary font-bold rounded-xl shadow-xl shadow-primary/25 hover:translate-y-[-2px] transition-all flex items-center justify-center">
                            Donate Now
                            <span class="material-symbols-outlined ml-2" style="font-variation-settings: 'FILL' 1;">favorite</span>
</a>
<a href="{{ route('register') }}" class="px-8 py-4 bg-secondary-container text-on-secondary-container font-bold rounded-xl hover:bg-surface-container-high transition-all flex items-center justify-center">
                            Request Blood
                            <span class="material-symbols-outlined ml-2">medical_services</span>
</a>
</div>
</div>
<div class="relative">
<div class="absolute -top-10 -right-10 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
<div class="absolute -bottom-10 -left-10 w-64 h-64 bg-tertiary/5 rounded-full blur-3xl"></div>
<div class="relative rounded-[2rem] overflow-hidden shadow-2xl transform lg:rotate-3 hover:rotate-0 transition-transform duration-700 aspect-[4/3] bg-surface-container-lowest p-4">
<img alt="Healthcare Coordination" class="w-full h-full object-cover rounded-[1.5rem]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAsDqf15ZlEaN8s2xmpewwE-lEkgLC3Vwq-UYqEUp6dIkgn0ZwMJFC_eUz_18xPSHNSUFzMpDE8EBoKmKqE0976cFYSBA93tcELeADHmeOhlOqxI-ndomtmV8ASm3xgqSiL-lR3cew6Vbkm08gOzGjFbw4TbiJLXdgMTHG30vtFgy6QNpRZh87g5eqZ9zN-RQ5-afqJZWCaY7aomInb-BxTwxMrTAsBr7TsOZgRwQrxWdLXgJTvNn49alcLcDqG4DvfWOQ7J0u6mA"/>
</div>
</div>
</div>
</section>
<section class="py-12 bg-surface-container-lowest" id="actors">
<div class="max-w-7xl mx-auto px-6">
<p class="text-center text-label-sm font-bold text-on-secondary-container/60 uppercase tracking-[0.2em] mb-10">Trusted by Global Healthcare Networks</p>
<div class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
<div class="text-xl font-black font-headline tracking-tighter">St. Jude Medical</div>
<div class="text-xl font-black font-headline tracking-tighter">Red Cross Alliance</div>
<div class="text-xl font-black font-headline tracking-tighter">Global Health Lab</div>
<div class="text-xl font-black font-headline tracking-tighter">City General</div>
<div class="text-xl font-black font-headline tracking-tighter">PulseCare Network</div>
</div>
</div>
</section>
<section class="py-24 px-6 bg-surface" id="how-it-works">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
<div class="max-w-2xl">
<h2 class="text-4xl lg:text-5xl font-black font-headline text-on-background mb-4">A Unified Ecosystem</h2>
<p class="text-on-secondary-container">Three specialized pathways designed for maximum impact and minimal friction.</p>
</div>
</div>
<div class="grid lg:grid-cols-12 gap-6">
<div class="lg:col-span-4 bg-surface-container-lowest rounded-[2rem] p-8 flex flex-col hover:bg-surface-container-low transition-colors group">
<div class="w-12 h-12 rounded-2xl bg-primary-fixed flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-on-primary-fixed-variant">volunteer_activism</span>
</div>
<h3 class="text-2xl font-bold font-headline mb-4">For Donors</h3>
<p class="text-on-secondary-container leading-relaxed mb-8">Schedule appointments, track your impact, and get notified when your specific blood type is in critical demand nearby.</p>
<div class="mt-auto pt-6 border-t border-outline-variant/10">
<a class="flex items-center font-bold text-primary hover:gap-2 transition-all" href="{{ route('register') }}">
                                Start Your Journey
                                <span class="material-symbols-outlined ml-2">arrow_forward</span>
</a>
</div>
</div>
<div class="lg:col-span-4 bg-primary-container text-on-primary-container rounded-[2rem] p-8 flex flex-col shadow-xl shadow-primary/20">
<div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">emergency_share</span>
</div>
<h3 class="text-2xl font-bold font-headline mb-4">For Recipients</h3>
<p class="opacity-90 leading-relaxed mb-8">Post emergency requests that alert our entire verified network in seconds. Seamless coordination during your most critical moments.</p>
<div class="mt-auto pt-6 border-t border-white/10">
<a class="flex items-center font-bold text-white" href="{{ route('register') }}">
                                Submit Request
                                <span class="material-symbols-outlined ml-2">arrow_forward</span>
</a>
</div>
</div>
<div class="lg:col-span-4 bg-surface-container-lowest rounded-[2rem] p-8 flex flex-col hover:bg-surface-container-low transition-colors group" id="hospital">
<div class="w-12 h-12 rounded-2xl bg-secondary-fixed flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-on-secondary-fixed-variant">domain</span>
</div>
<h3 class="text-2xl font-bold font-headline mb-4">For Hospitals</h3>
<p class="text-on-secondary-container leading-relaxed mb-8">Manage inventory, verify matches instantly, and connect with other institutions for cross-city blood transfers.</p>
<div class="mt-auto pt-6 border-t border-outline-variant/10">
<a class="flex items-center font-bold text-secondary hover:gap-2 transition-all" href="{{ route('register.hospital') }}">
                                Partner With Us
                                <span class="material-symbols-outlined ml-2">arrow_forward</span>
</a>
</div>
</div>
</div>
</div>
</section>
<section class="py-24 px-6 text-center">
<div class="max-w-3xl mx-auto">
<h2 class="text-5xl lg:text-6xl font-black font-headline text-on-background mb-8">Ready to join the <span class="text-primary">pulse</span>?</h2>
<p class="text-lg text-on-secondary-container mb-12">Whether you are a donor, a patient in need, or a healthcare institution, there is a place for you in our lifesaving mission.</p>
<div class="flex flex-wrap justify-center gap-4">
<a href="{{ route('register') }}" class="px-10 py-5 bg-primary text-white font-black font-headline rounded-2xl shadow-2xl shadow-primary/30 hover:scale-105 active:scale-95 transition-all">Create Donor Account</a>
<a href="{{ route('register.hospital') }}" class="px-10 py-5 bg-white text-on-surface font-black font-headline border-2 border-outline-variant/30 rounded-2xl hover:bg-surface-container-low transition-all">Institutional Portal</a>
</div>
</div>
</section>
</main>
<footer class="bg-slate-50 dark:bg-slate-950 w-full py-12 px-6 border-t border-slate-200/10 tonal-shift">
<div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-7xl mx-auto">
<div class="col-span-1 md:col-span-1">
<div class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-4">LifeLink</div>
<p class="text-xs text-slate-500 leading-relaxed max-w-xs">Connecting the world's vital resources to the moments they are needed most. A revolution in emergency coordination.</p>
</div>
<div>
<h4 class="text-on-surface font-bold text-sm mb-4">Platform</h4>
<ul class="space-y-2">
<li><a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#how-it-works">How it Works</a></li>
<li><a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#hospital">Hospital Network</a></li>
<li><a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#">Safety Standards</a></li>
<li><a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#">Global Directory</a></li>
</ul>
</div>
<div>
<h4 class="text-on-surface font-bold text-sm mb-4">Company</h4>
<ul class="space-y-2">
<li><a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#">About Us</a></li>
<li><a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#">Careers</a></li>
<li><a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#">Newsroom</a></li>
<li><a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#">Contact Support</a></li>
</ul>
</div>
<div>
<h4 class="text-on-surface font-bold text-sm mb-4">Get Started</h4>
<div class="flex flex-col gap-2">
<a href="{{ route('register') }}" class="rounded-lg bg-primary px-3 py-2 text-xs font-bold text-white text-center">User Signup</a>
<a href="{{ route('register.hospital') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-bold text-slate-700 text-center">Hospital Signup</a>
</div>
</div>
</div>
<div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-slate-200/10 flex flex-col md:flex-row justify-between items-center gap-4">
<p class="font-inter text-xs text-slate-500">© {{ date('Y') }} LifeLink Vital Pulse. All rights reserved.</p>
<div class="flex gap-6">
<a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#">Privacy Policy</a>
<a class="text-slate-400 hover:text-rose-500 text-xs transition-all" href="#">Terms of Service</a>
</div>
</div>
</footer>
</body>
</html>
