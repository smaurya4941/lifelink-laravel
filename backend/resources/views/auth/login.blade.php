<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>LifeLink | Login</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
      .bg-glass {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
      }
      .ghost-border {
        border: 1px solid rgba(229, 189, 190, 0.15);
      }
      .primary-gradient {
        background: linear-gradient(135deg, #b80035 0%, #e11d48 100%);
      }
</style>
</head>
<body class="bg-surface font-body text-on-surface selection:bg-primary-fixed">
<nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-xl shadow-sm px-6 py-3 flex justify-between items-center">
<div class="text-2xl font-black tracking-tighter text-rose-700 font-headline">LifeLink</div>
<div class="hidden md:flex space-x-8">
<a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all" href="{{ url('/') }}">Home</a>
<a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all" href="{{ url('/') }}#how-it-works">How it Works</a>
<a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all" href="{{ url('/') }}#actors">Donor/Recipient</a>
<a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all" href="{{ url('/') }}#hospital">Hospital</a>
</div>
<div class="flex items-center space-x-4">
<a href="{{ route('login') }}" class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500">Login</a>
<a href="{{ route('register') }}" class="primary-gradient text-on-primary font-headline font-bold text-sm px-5 py-2 rounded-xl scale-95 active:opacity-80 transition-transform">Register</a>
</div>
</nav>
<main class="min-h-screen pt-24 pb-12 flex items-center justify-center px-4 md:px-6">
<div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
<section class="lg:col-span-5 order-2 lg:order-1">
<div class="space-y-8">
<div class="space-y-2">
<h1 class="text-4xl md:text-5xl font-black font-headline text-on-surface tracking-tight">Welcome back to Vital Pulse</h1>
<p class="text-on-secondary-container text-lg leading-relaxed max-w-md">Access your dashboard to manage donations, track live blood requests, and save lives in real-time.</p>
</div>
<div class="bg-surface-container-lowest p-8 rounded-xl ghost-border shadow-sm">

@if (session('status'))
    <div class="mb-4 rounded-lg bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
@endif

<form class="space-y-5" method="POST" action="{{ route('login') }}">
@csrf
<div class="space-y-1.5">
<label class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant ml-1">Email Address</label>
<div class="relative group">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">mail</span>
<input class="w-full pl-12 pr-4 py-3.5 bg-surface-container-low border-none rounded-xl focus:ring-4 focus:ring-primary-fixed/50 transition-all outline-none text-on-surface placeholder:text-outline" placeholder="name@organization.com" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"/>
</div>
@error('email')<p class="text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
</div>
<div class="space-y-1.5">
<div class="flex justify-between items-center ml-1">
<label class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Password</label>
@if (Route::has('password.request'))
<a class="text-xs font-bold text-primary hover:underline" href="{{ route('password.request') }}">Forgot?</a>
@endif
</div>
<div class="relative group">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock</span>
<input id="password" class="w-full pl-12 pr-12 py-3.5 bg-surface-container-low border-none rounded-xl focus:ring-4 focus:ring-primary-fixed/50 transition-all outline-none text-on-surface placeholder:text-outline" placeholder="••••••••" type="password" name="password" required autocomplete="current-password"/>
<button id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary" type="button" aria-label="Toggle password visibility" aria-controls="password" aria-pressed="false">
<span id="toggle-password-icon" class="material-symbols-outlined">visibility</span>
</button>
</div>
@error('password')<p class="text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
</div>
<div class="flex items-center space-x-2 ml-1">
<input class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary" id="remember" type="checkbox" name="remember" @checked(old('remember'))/>
<label class="text-sm text-on-secondary-container" for="remember">Stay logged in for 30 days</label>
</div>
<button class="w-full primary-gradient text-on-primary font-headline font-bold py-4 rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all" type="submit">
                                Sign In to LifeLink
                            </button>
</form>
<div class="relative my-8">
<div class="absolute inset-0 flex items-center"><div class="w-full border-t border-outline-variant/30"></div></div>
<div class="relative flex justify-center text-xs uppercase tracking-widest"><span class="bg-surface-container-lowest px-4 text-outline font-bold">Or continue with</span></div>
</div>
<div class="grid grid-cols-2 gap-4">
<button class="flex items-center justify-center space-x-2 py-3 bg-surface-container-low rounded-xl font-semibold text-sm text-on-surface opacity-60 cursor-not-allowed" type="button" disabled aria-disabled="true" title="Google sign-in coming soon">
<img alt="Google" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCEHwvmmNNqk4JPuD6GOt-89qgQN5H_RbXfT2fJ1FvBmlxc7Lwi1cQqO2pxm6GnmTvHdmW7XQ5v-bu8TRR4kO8Pr_i7ajODE888eZ8Xa_u4zbIXza7_LKh-V35IBXZ_0Ikx9LQYw9Aitw9EDI8JIhh-TCOBHldJJ5m34FKrjH4xfb2yw5HuOODwNPdcx-ZmrOrZakAnjI_S-ZsVHzd0ylk8zd59aOZucEkTsGOCY6PR4vTTK9A8Z4alJrGmp734UWIBj8Zg3BnE9g"/>
<span>Google</span>
</button>
<button class="flex items-center justify-center space-x-2 py-3 bg-surface-container-low rounded-xl font-semibold text-sm text-on-surface opacity-60 cursor-not-allowed" type="button" disabled aria-disabled="true" title="Apple sign-in coming soon">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">ios</span>
<span>Apple</span>
</button>
</div>
<p class="mt-3 text-center text-xs font-medium text-on-secondary-container">Social login is coming soon.</p>
</div>
<p class="text-center text-on-secondary-container text-sm">
                        New to LifeLink?
                        <a class="text-primary font-bold hover:underline" href="{{ route('register') }}">Create a personal account</a>
                        or
                        <a class="text-primary font-bold hover:underline" href="{{ route('register.hospital') }}">Register your hospital</a>
</p>
</div>
</section>
<section class="lg:col-span-7 order-1 lg:order-2">
<div class="relative rounded-[2rem] overflow-hidden aspect-[4/3] lg:aspect-square group">
<img alt="Blood Donation Lab" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDZnjcAvYZ4xGIawTh1lra7ExFdLRf6dSkO8hiN764TPuoPrV58SHn05rQK1g4h8CtFYmaDS8sU_nXzJC2bWzzIyx7MbOpiWbCHnKF-2sEZmt5SRdXO4BHjTZ1tBxK4jM8-HPcQQthqe8vpkjeJaCF_HY0V7emcHXHdr-HLkwrP8IhG4XnKJRhOH8HEYXPdhtleR33qtKpY7uFW02pzMp1ishgMijuS_OsM-tDa0TreE5sKDy9PivDM21x_zQMfshi7FbIEFcEWVg"/>
<div class="absolute inset-0 bg-gradient-to-t from-on-background/80 via-transparent to-transparent flex flex-col justify-end p-12">
<div class="max-w-md space-y-4">
<div class="flex space-x-1">
<span class="material-symbols-outlined text-primary-fixed" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-primary-fixed" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-primary-fixed" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-primary-fixed" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-primary-fixed" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
<blockquote class="text-2xl font-headline font-bold text-white leading-tight">
                                "LifeLink has cut our emergency response time by 40%. It's more than software; it's a lifeline for our community."
                            </blockquote>
<div class="flex items-center space-x-4">
<div class="w-12 h-12 rounded-full border-2 border-primary-fixed overflow-hidden">
<img alt="Dr. Sarah" src="https://lh3.googleusercontent.com/aida-public/AB6AXuABJoa5RRZ2M-S6-n8GTl-NfNsFVDTDAM82D95a4ypoOiO7rRszpR0ubakxQoOv7VStTEhZpMFsihstozIH8V2C0i2NEzysNDl89t2JNem81_sh9QoaxADUp7jpShHDxFvqHzFhuMBpCxtd2OFF4Dnz1MrRRT8ZOwHNYtcalSGpb-dA0na8i3Db-A0HTlW_LTgXOG0Xy3thCSYZlKB-IpxITFkBJp0C0QLBmkavD9wkJ8A_Sbb5bum0tGDodOEEGG-TxqCYz1Hu9Q"/>
</div>
<div>
<p class="text-white font-bold">Dr. Sarah Chen</p>
<p class="text-primary-fixed text-xs font-semibold uppercase tracking-widest">Chief Medical Officer, St. Jude's</p>
</div>
</div>
</div>
</div>
<div class="absolute top-8 right-8 bg-glass p-4 rounded-2xl ghost-border">
<div class="flex items-center space-x-3">
<div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
<span class="text-xs font-black uppercase tracking-tighter font-headline text-on-surface">1,204 Live Donors Online</span>
</div>
</div>
</div>
</section>
</div>
</main>
<footer class="bg-slate-50 border-t border-slate-200/10 py-12 px-6">
<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
<div class="space-y-4">
<div class="text-lg font-bold text-slate-900 font-headline">LifeLink</div>
<p class="text-xs text-slate-500 max-w-xs leading-relaxed">Revolutionizing the global blood supply chain through technology, transparency, and human connection.</p>
</div>
<div>
<h4 class="text-xs font-black uppercase tracking-widest text-on-surface mb-4">Platform</h4>
<ul class="space-y-2">
<li><a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="{{ url('/') }}#how-it-works">How it Works</a></li>
<li><a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="{{ url('/') }}#hospital">Hospital Network</a></li>
<li><a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="{{ url('/') }}">Donor Stories</a></li>
</ul>
</div>
<div>
<h4 class="text-xs font-black uppercase tracking-widest text-on-surface mb-4">Legal</h4>
<ul class="space-y-2">
<li><a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Privacy Policy</a></li>
<li><a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Terms of Service</a></li>
<li><a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Global Directory</a></li>
</ul>
</div>
<div>
<h4 class="text-xs font-black uppercase tracking-widest text-on-surface mb-4">Support</h4>
<ul class="space-y-2">
<li><a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Help Center</a></li>
<li><a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Contact Support</a></li>
<li><a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Emergency Hotline</a></li>
</ul>
</div>
</div>
<div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-slate-200/50 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
<p class="text-xs text-slate-500">© {{ date('Y') }} LifeLink Vital Pulse. All rights reserved.</p>
<div class="flex space-x-6">
<a class="text-slate-400 hover:text-rose-500 transition-all" href="#"><span class="material-symbols-outlined text-sm">public</span></a>
<a class="text-slate-400 hover:text-rose-500 transition-all" href="#"><span class="material-symbols-outlined text-sm">alternate_email</span></a>
<a class="text-slate-400 hover:text-rose-500 transition-all" href="#"><span class="material-symbols-outlined text-sm">share</span></a>
</div>
</div>
</footer>
<script>
(() => {
  const passwordInput = document.getElementById('password');
  const toggleButton = document.getElementById('toggle-password');
  const toggleIcon = document.getElementById('toggle-password-icon');

  if (!passwordInput || !toggleButton || !toggleIcon) return;

  toggleButton.addEventListener('click', () => {
    const isHidden = passwordInput.type === 'password';
    passwordInput.type = isHidden ? 'text' : 'password';
    toggleIcon.textContent = isHidden ? 'visibility_off' : 'visibility';
    toggleButton.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
  });
})();
</script></body>
</html>



