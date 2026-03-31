<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>LifeLink Onboarding | The Vital Pulse</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
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
        "headline": ["Manrope", "sans-serif"],
        "body": ["Inter", "sans-serif"],
        "label": ["Inter", "sans-serif"]
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
.bg-vital-gradient {
  background: linear-gradient(135deg, #b80035 0%, #e11d48 100%);
}
.capability-card.active {
  transform: translateY(-4px);
  border-color: rgba(225, 29, 72, 0.35);
  box-shadow: 0 10px 25px rgba(184, 0, 53, 0.08);
}
.capability-card.active .capability-dot {
  opacity: 1;
}
</style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">
<nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-xl shadow-sm bg-slate-50/50">
  <div class="flex justify-between items-center px-6 py-3 max-w-full mx-auto">
    <div class="flex items-center gap-8">
      <span class="text-2xl font-black tracking-tighter text-rose-700 font-headline">LifeLink</span>
      <div class="hidden md:flex items-center gap-6">
        <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all duration-300" href="{{ url('/') }}">Home</a>
        <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all duration-300" href="{{ url('/') }}#how-it-works">How it Works</a>
        <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all duration-300" href="{{ url('/') }}#actors">Donor/Recipient</a>
        <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all duration-300" href="{{ url('/') }}#hospital">Hospital</a>
      </div>
    </div>
    <div class="flex items-center gap-4">
      <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-rose-500 transition-colors">Login</a>
      <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-bold bg-vital-gradient text-white rounded-xl shadow-sm scale-95 active:opacity-80 transition-transform">Register</a>
    </div>
  </div>
</nav>

<main class="min-h-screen pt-24 pb-16 px-6">
  <div class="max-w-4xl mx-auto">
    <header class="mb-12 text-center md:text-left">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-[10px] font-bold tracking-widest uppercase mb-4">
        Account Setup
      </div>
      <h1 class="text-4xl md:text-5xl font-headline font-extrabold tracking-tight text-on-surface mb-4">
        How would you like to <span class="text-primary">contribute</span>?
      </h1>
      <p class="text-lg text-on-secondary-container max-w-xl font-medium">
        Select your roles within the LifeLink ecosystem. You can be both a donor and a potential recipient.
      </p>
    </header>

    @error('is_donor')
      <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('onboarding.capabilities.update') }}">
      @csrf
      @method('PATCH')
      <input type="hidden" name="is_donor" value="0">
      <input type="hidden" name="is_recipient" value="0">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <label class="capability-card group relative bg-surface-container-lowest p-8 rounded-xl transition-all duration-300 hover:translate-y-[-4px] cursor-pointer ring-2 ring-transparent hover:ring-primary-container/30 @if(old('is_donor', $user->is_donor)) active @endif">
          <input id="is_donor" type="checkbox" name="is_donor" value="1" class="sr-only" @checked(old('is_donor', $user->is_donor))>
          <div class="flex justify-between items-start mb-8">
            <div class="w-14 h-14 bg-primary-fixed rounded-2xl flex items-center justify-center">
              <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">volunteer_activism</span>
            </div>
            <div class="h-6 w-6 rounded-full border-2 border-outline-variant flex items-center justify-center group-hover:border-primary transition-colors">
              <div class="capability-dot h-3 w-3 rounded-full bg-primary opacity-0 transition-opacity"></div>
            </div>
          </div>
          <h3 class="text-2xl font-headline font-bold text-on-surface mb-3">I want to donate blood</h3>
          <p class="text-on-secondary-container text-sm leading-relaxed mb-6">
            Become a hero. Share your vital pulse with those in urgent need. We will guide you through scheduling, eligibility, and local donation centers.
          </p>
          <ul class="space-y-3">
            <li class="flex items-center gap-3 text-xs font-medium text-on-surface-variant">
              <span class="material-symbols-outlined text-tertiary-container text-sm">check_circle</span>
              Schedule local appointments
            </li>
            <li class="flex items-center gap-3 text-xs font-medium text-on-surface-variant">
              <span class="material-symbols-outlined text-tertiary-container text-sm">check_circle</span>
              Track your impact and health stats
            </li>
          </ul>
          <div class="absolute bottom-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
            <span class="material-symbols-outlined text-9xl">bloodtype</span>
          </div>
        </label>

        <label class="capability-card group relative bg-surface-container-lowest p-8 rounded-xl transition-all duration-300 hover:translate-y-[-4px] cursor-pointer ring-2 ring-transparent hover:ring-primary-container/30 @if(old('is_recipient', $user->is_recipient)) active @endif">
          <input id="is_recipient" type="checkbox" name="is_recipient" value="1" class="sr-only" @checked(old('is_recipient', $user->is_recipient))>
          <div class="flex justify-between items-start mb-8">
            <div class="w-14 h-14 bg-secondary-container rounded-2xl flex items-center justify-center">
              <span class="material-symbols-outlined text-secondary text-3xl" style="font-variation-settings: 'FILL' 1;">medical_services</span>
            </div>
            <div class="h-6 w-6 rounded-full border-2 border-outline-variant flex items-center justify-center group-hover:border-primary transition-colors">
              <div class="capability-dot h-3 w-3 rounded-full bg-primary opacity-0 transition-opacity"></div>
            </div>
          </div>
          <h3 class="text-2xl font-headline font-bold text-on-surface mb-3">I may need blood</h3>
          <p class="text-on-secondary-container text-sm leading-relaxed mb-6">
            Secure your vital needs. Access the donor network, request emergency matches, and manage hospital coordination.
          </p>
          <ul class="space-y-3">
            <li class="flex items-center gap-3 text-xs font-medium text-on-surface-variant">
              <span class="material-symbols-outlined text-tertiary-container text-sm">check_circle</span>
              Quick emergency requests
            </li>
            <li class="flex items-center gap-3 text-xs font-medium text-on-surface-variant">
              <span class="material-symbols-outlined text-tertiary-container text-sm">check_circle</span>
              Live match tracking
            </li>
          </ul>
          <div class="absolute bottom-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
            <span class="material-symbols-outlined text-9xl">emergency</span>
          </div>
        </label>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="md:col-span-2 bg-surface-container-low p-6 rounded-xl border-l-4 border-primary">
          <div class="flex gap-4">
            <span class="material-symbols-outlined text-primary">info</span>
            <div>
              <h4 class="font-headline font-bold text-on-surface mb-1 text-sm">Dual Role Compatibility</h4>
              <p class="text-xs text-on-secondary-container leading-relaxed">
                Most members are both donors and potential recipients. Selecting both gives you full access to requests and matches.
              </p>
            </div>
          </div>
        </div>
        <div class="bg-surface-container-high p-6 rounded-xl flex flex-col justify-center items-center text-center">
          <span class="text-2xl font-black text-rose-700 font-headline mb-1">10k+</span>
          <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Active Matches</span>
        </div>
      </div>

      <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-6 border-t border-outline-variant/20">
        <div class="flex items-center gap-4">
          <div class="flex -space-x-3">
            <img class="w-10 h-10 rounded-full border-2 border-surface" alt="community member" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCdPq-Rl_9uNPT6p_O0DIXVzZykS8ultTnKBYUNDLlLfJEeZuVKM7znPZX6HSZHf94vpWCIyDJ4R-2qb4iDK5WajyFUXKjf_1h_2hqq0a5_FPKdLJumxutMLfEMHxMcPH3OTHNfSxhWrwb6tUEYZx1_wwtl2UdDMcTfN8OO8yrR0tVt09eCrpcpLSjW5DwiwkTh4XvYHodCOz-7KdYNtPlew-W3orumSrMKmxZO-JwsgwRl6U2BI-Hwfz8WJr8E2aKsNXuQSM8C4A"/>
            <img class="w-10 h-10 rounded-full border-2 border-surface" alt="community member" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaG6Ioz11nJf6hpoiraspmGqvosn_3x8gPm4vLzpbNDuV4UYKQMxDw62OSW7BwfAbCSnqjbrRa14Sa2onpcMzHj3yGxVjMK2-MgwdITcKOMgC2cp_gHHYj0KJbDlGliDIQtHkSkEco5cSy-xIozl8exrRFzveWiAWbekPm1A06vRw4qApgkZ0fMZBpfxoPWFgPQI4EDGggbIbfD2L4Boqdzu3oa8F-26a5EHWmmYfYbxbcJAp6l5qQ-kBu1Zj5ieWQn0W9jzwRhQ"/>
            <img class="w-10 h-10 rounded-full border-2 border-surface" alt="community member" src="https://lh3.googleusercontent.com/aida-public/AB6AXuApbWqve_fwynj9eBcqHOubnOvU4PNIrPaxXMDpHclgJ95tHgtcAeYv3yGQtmeXfyKozmTQWhDwwdbEK7uIJKixe-qdXw9px1rcqjfUuPdkttpUNnt_AYQ7I55z8v2Njsk770aij9TKngUhOyrT59tz44R6U78Fx5EGoiWaCvzxEgB4FyRnGlN0oTbQLet0H4f_xHCuFFk469ULXhWxDGzk-Lg8AKgK8oDvEeD3sskbITNhiicG5r0zCvlQ4WjnOLZT3cnQHRJLIw"/>
          </div>
          <p class="text-xs font-medium text-on-secondary-container">Join 2,400+ people onboarding this week</p>
        </div>
        <button type="submit" class="w-full md:w-auto px-10 py-4 bg-vital-gradient text-white font-headline font-extrabold rounded-xl shadow-lg hover:shadow-primary/20 hover:translate-y-[-2px] transition-all flex items-center justify-center gap-2">
          Continue to Profile
          <span class="material-symbols-outlined">arrow_forward</span>
        </button>
      </div>
    </form>
  </div>
</main>

<footer class="bg-slate-50 w-full py-12 px-6 border-t border-slate-200/10">
  <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-7xl mx-auto">
    <div class="col-span-1 md:col-span-1">
      <span class="text-lg font-bold text-slate-900">LifeLink</span>
      <p class="mt-4 text-xs text-slate-500 leading-relaxed">
        Connecting vital resources with human need through technical precision and compassionate design.
      </p>
    </div>
    <div class="col-span-1">
      <h5 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Legal</h5>
      <div class="flex flex-col gap-2">
        <a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Privacy Policy</a>
        <a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Terms of Service</a>
      </div>
    </div>
    <div class="col-span-1">
      <h5 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Support</h5>
      <div class="flex flex-col gap-2">
        <a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Contact Support</a>
        <a class="text-xs text-slate-400 hover:text-rose-500 transition-colors" href="#">Global Directory</a>
      </div>
    </div>
    <div class="col-span-1 flex flex-col justify-end">
      <p class="text-xs text-slate-500">© {{ date('Y') }} LifeLink Vital Pulse. All rights reserved.</p>
    </div>
  </div>
</footer>

<script>
(() => {
  const cards = document.querySelectorAll('.capability-card');

  const syncCardState = (card) => {
    const checkbox = card.querySelector('input[type="checkbox"]');
    if (!checkbox) return;
    card.classList.toggle('active', checkbox.checked);
  };

  cards.forEach((card) => {
    syncCardState(card);

    const checkbox = card.querySelector('input[type="checkbox"]');
    if (!checkbox) return;

    checkbox.addEventListener('change', () => syncCardState(card));
  });
})();
</script>
</body>
</html>
