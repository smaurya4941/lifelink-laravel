<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Register | LifeLink</title>
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
  vertical-align: middle;
}
body {
  font-family: 'Inter', sans-serif;
  background-color: #f8f9ff;
  color: #0b1c30;
}
h1, h2, h3 {
  font-family: 'Manrope', sans-serif;
}
</style>
</head>
<body class="bg-surface text-on-surface antialiased">
<nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-xl shadow-sm">
  <div class="flex justify-between items-center px-6 py-3 max-w-full mx-auto">
    <div class="text-2xl font-black tracking-tighter text-rose-700 font-headline">LifeLink</div>
    <div class="hidden md:flex items-center space-x-8">
      <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition-all duration-300 px-3 py-1 rounded-lg" href="{{ url('/') }}">Home</a>
      <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition-all duration-300 px-3 py-1 rounded-lg" href="{{ url('/') }}#how-it-works">How it Works</a>
      <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition-all duration-300 px-3 py-1 rounded-lg" href="{{ url('/') }}#actors">Donor/Recipient</a>
      <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition-all duration-300 px-3 py-1 rounded-lg" href="{{ url('/') }}#hospital">Hospital</a>
    </div>
    <div class="flex items-center space-x-4">
      <a class="hidden md:block font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-600 transition-all duration-300" href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}" class="bg-primary-container text-on-primary px-5 py-2 rounded-xl font-bold text-sm scale-95 active:opacity-80 transition-transform">Register</a>
      <div class="hidden md:flex items-center space-x-2 text-slate-400">
        <span class="material-symbols-outlined cursor-default">notifications</span>
        <span class="material-symbols-outlined cursor-default">account_circle</span>
      </div>
    </div>
  </div>
</nav>

<main class="min-h-screen pt-24 pb-16 px-4 md:px-8 flex items-center justify-center">
  <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-12 gap-0 overflow-hidden bg-surface-container-lowest rounded-3xl shadow-xl shadow-on-surface/5">
    <div class="hidden md:flex md:col-span-5 relative overflow-hidden bg-primary items-center justify-center p-12">
      <div class="absolute inset-0 opacity-40 bg-gradient-to-br from-primary via-primary-container to-rose-900"></div>
      <img alt="Abstract medical visual" class="absolute inset-0 object-cover opacity-60 mix-blend-overlay" src="https://lh3.googleusercontent.com/aida-public/AB6AXuASn7ZZl53KzgrfBfWz0egMebrfM20VwD0xF9dIHJpJiW3pjgvvlP0wW8RE_LjIle_I4KSn6CAotdg0rrUQR3HB_jwE7GMIp2TDu4B1C5slc7Z7EiNWvLz6-oXvtrh2ubDmtWD0QG9gNY-j_vKrvil36iOXOMJ9SBZpK2eo6eOEPmYU3Wk8-9PPrQcUEK_gUZeVRyt1avVcglIxUzRhlrKopoC7HqD5w9q0NPkvlENRqlvGGH-qCaljNB0wHDaiDe-DNxy5Qcz-KQ"/>
      <div class="relative z-10 text-on-primary space-y-8">
        <div class="inline-flex items-center px-3 py-1 bg-white/10 backdrop-blur-md rounded-full border border-white/20">
          <span class="material-symbols-outlined text-xs mr-2">verified</span>
          <span class="text-[10px] uppercase tracking-widest font-bold">Trusted Network</span>
        </div>
        <h2 class="text-4xl lg:text-5xl font-extrabold font-headline leading-tight tracking-tighter">Join the Pulse of Life.</h2>
        <p class="text-on-primary/80 font-body text-lg max-w-md leading-relaxed">Your registration is the first step in a journey that saves lives. Connect with a global network of donors and hospitals instantly.</p>
        <div class="grid grid-cols-2 gap-6 pt-8">
          <div class="space-y-1">
            <p class="text-2xl font-black font-headline">2.4M</p>
            <p class="text-xs uppercase tracking-widest opacity-60">Active Donors</p>
          </div>
          <div class="space-y-1">
            <p class="text-2xl font-black font-headline">450+</p>
            <p class="text-xs uppercase tracking-widest opacity-60">Partner Hospitals</p>
          </div>
        </div>
      </div>
    </div>

    <div class="md:col-span-7 bg-surface-container-lowest p-8 md:p-16">
      <div class="max-w-md mx-auto space-y-10">
        <div class="space-y-2">
          <h1 class="text-3xl font-black font-headline text-on-surface tracking-tighter">Create Account</h1>
          <p class="text-on-secondary-container font-body">Already have an account? <a class="text-primary font-bold hover:underline" href="{{ route('login') }}">Sign in here</a></p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
          @csrf

          @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
              Please review the highlighted fields and try again.
            </div>
          @endif

          <div class="space-y-2">
            <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider ml-1" for="name">Full Name</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">person</span>
              <input id="name" name="name" value="{{ old('name') }}" class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-4 focus:ring-primary-fixed/50 transition-all placeholder:text-slate-400 text-on-surface font-medium" placeholder="John Doe" type="text" required autofocus autocomplete="name"/>
            </div>
            @error('name')<p class="text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider ml-1" for="email">Email Address</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">mail</span>
              <input id="email" name="email" value="{{ old('email') }}" class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-4 focus:ring-primary-fixed/50 transition-all placeholder:text-slate-400 text-on-surface font-medium" placeholder="name@lifelink.org" type="email" required autocomplete="username"/>
            </div>
            @error('email')<p class="text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider ml-1" for="password">Password</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">lock</span>
              <input id="password" name="password" class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-12 focus:ring-4 focus:ring-primary-fixed/50 transition-all placeholder:text-slate-400 text-on-surface font-medium" placeholder="••••••••••••" type="password" required autocomplete="new-password"/>
              <button id="toggle-password" type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary" aria-label="Toggle password visibility" aria-controls="password" aria-pressed="false">
                <span id="toggle-password-icon" class="material-symbols-outlined">visibility</span>
              </button>
            </div>
            <p class="text-[10px] text-on-secondary-container/60 ml-1">Use at least 6 characters. You can complete the rest of your profile after signup.</p>
            @error('password')<p class="text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
          </div>

          <div class="space-y-2">
            <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider ml-1" for="password_confirmation">Confirm Password</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">shield_lock</span>
              <input id="password_confirmation" name="password_confirmation" class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-4 focus:ring-primary-fixed/50 transition-all placeholder:text-slate-400 text-on-surface font-medium" placeholder="Repeat your password" type="password" required autocomplete="new-password"/>
            </div>
            @error('password_confirmation')<p class="text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
          </div>

          <div class="flex items-center space-x-3 py-2">
            <input class="w-5 h-5 rounded-md border-none bg-surface-container-low text-primary focus:ring-primary-fixed cursor-pointer" id="terms" type="checkbox" required/>
            <label class="text-xs text-on-secondary-container leading-relaxed" for="terms">
              I agree to the <a class="text-primary font-bold hover:underline" href="#">Terms of Service</a> and <a class="text-primary font-bold hover:underline" href="#">Privacy Policy</a> regarding my medical data.
            </label>
          </div>

          <button class="w-full py-5 bg-gradient-to-r from-primary to-primary-container text-on-primary font-black text-sm uppercase tracking-widest rounded-xl shadow-xl shadow-primary/20 hover:shadow-primary/30 active:scale-[0.98] transition-all" type="submit">
            Create Account
          </button>
        </form>

        <div class="relative flex py-2 items-center">
          <div class="flex-grow border-t border-slate-200/50"></div>
          <span class="flex-shrink mx-4 text-xs font-bold text-slate-400 uppercase tracking-widest">or register with</span>
          <div class="flex-grow border-t border-slate-200/50"></div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <button class="flex items-center justify-center space-x-2 py-3 bg-surface-container-low rounded-xl font-bold text-xs text-on-surface opacity-60 cursor-not-allowed" type="button" disabled aria-disabled="true" title="Google sign-up coming soon">
            <img alt="Google" class="w-4 h-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDOpmizfFhcN8dmNebdsdGplvNKnhRJaiPcdeyqrKiPsGR16-7rkDmlv9xmLrnTvX-UgcTvyf3KnY5aB_mAQzbexqG0LzGTswosaeGYMTtqZ7F4JQ-HG4zIDHmIe3ta5DIy7oJK7Yt92YO9LN0zLm-VccHPam9XruOMNrzcA1Jk-bm5cU4f8DtOr8qzqd3aiXCcLtboWFu16AM4S7RdFUb8twU5OxyIEM3bTsW36BP70XKQtDfnqH6aVHjvtD-LuaOGqaSM-KQ_6w"/>
            <span>Google</span>
          </button>
          <button class="flex items-center justify-center space-x-2 py-3 bg-surface-container-low rounded-xl font-bold text-xs text-on-surface opacity-60 cursor-not-allowed" type="button" disabled aria-disabled="true" title="GitHub sign-up coming soon">
            <img alt="GitHub" class="w-4 h-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCM1eUgO1qd2Co0hbO-WRaQ7drlnr1aud53fdpRDHWntuMmC00DvWMo0fc7W1iWrCrBMkwoHMx0AcaUCYuKUqv5K9gpgctQdrieBr7sJLnJJNWKXj3-i2g-JcTl8dciVxlj4pJnyLbjxid_ZCGyr4kfGQnjUQC1Gq_8ZV_gZByXwVACkUjwzMB5tSDJG1zkqfEdbQw_B_69Yc70NLl9cq2AyM8t8dZYnfFKopjt7_tnBurwS0p1NnPGBuAxqNJFG2ydcq0jmPrHOA"/>
            <span>GitHub</span>
          </button>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
          <p class="text-sm font-semibold text-slate-900">Registering as a hospital?</p>
          <p class="mt-1 text-xs text-slate-600">Use the dedicated hospital flow with license and organization details.</p>
          <a href="{{ route('register.hospital') }}" class="mt-3 inline-flex text-sm font-semibold text-rose-700 hover:text-rose-800">Go to Hospital Registration</a>
        </div>
      </div>
    </div>
  </div>
</main>

<footer class="bg-slate-50 w-full py-12 px-6 border-t border-slate-200/10">
  <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-7xl mx-auto">
    <div class="space-y-4">
      <div class="text-lg font-bold text-slate-900">LifeLink</div>
      <p class="text-xs text-slate-500 max-w-xs leading-relaxed">Empowering the world to share the gift of life through technology, empathy, and seamless coordination.</p>
    </div>
    <div class="space-y-4">
      <h4 class="font-bold text-sm text-on-surface">Platform</h4>
      <ul class="space-y-2 text-xs text-slate-500">
        <li><a class="text-slate-400 hover:text-rose-500 transition-colors" href="{{ url('/') }}#how-it-works">How it Works</a></li>
        <li><a class="text-slate-400 hover:text-rose-500 transition-colors" href="{{ route('register.hospital') }}">Hospital Signup</a></li>
        <li><a class="text-slate-400 hover:text-rose-500 transition-colors" href="{{ url('/') }}#actors">Donor Resources</a></li>
      </ul>
    </div>
    <div class="space-y-4">
      <h4 class="font-bold text-sm text-on-surface">Legal</h4>
      <ul class="space-y-2 text-xs text-slate-500">
        <li><a class="text-slate-400 hover:text-rose-500 transition-colors" href="#">Privacy Policy</a></li>
        <li><a class="text-slate-400 hover:text-rose-500 transition-colors" href="#">Terms of Service</a></li>
      </ul>
    </div>
    <div class="space-y-4">
      <h4 class="font-bold text-sm text-on-surface">Connect</h4>
      <div class="flex space-x-4">
        <span class="material-symbols-outlined text-slate-400">public</span>
        <span class="material-symbols-outlined text-slate-400">mail</span>
        <span class="material-symbols-outlined text-slate-400">share</span>
      </div>
      <p class="text-[10px] text-slate-400">© {{ date('Y') }} LifeLink Vital Pulse. All rights reserved.</p>
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
</script>
</body>
</html>
