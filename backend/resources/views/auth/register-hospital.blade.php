<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Hospital Registration | LifeLink</title>
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
  vertical-align: middle;
}
.ghost-border {
  border: 1px solid rgba(229, 189, 190, 0.15);
}
.primary-gradient {
  background: linear-gradient(135deg, #b80035 0%, #e11d48 100%);
}
</style>
</head>
<body class="bg-surface font-body text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed-variant">
<nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-xl shadow-sm">
  <div class="flex justify-between items-center px-6 py-3 max-w-full mx-auto">
    <div class="flex items-center gap-8">
      <span class="text-2xl font-black tracking-tighter text-rose-700 font-headline">LifeLink</span>
      <div class="hidden md:flex gap-6 items-center">
        <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all duration-300" href="{{ url('/') }}">Home</a>
        <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all duration-300" href="{{ url('/') }}#how-it-works">How it Works</a>
        <a class="font-headline font-bold text-sm tracking-tight text-slate-600 hover:text-rose-500 transition-all duration-300" href="{{ url('/') }}#actors">Donor/Recipient</a>
        <a class="font-headline font-extrabold text-sm tracking-tight text-rose-700 border-b-2 border-rose-600" href="{{ route('register.hospital') }}">Hospital</a>
      </div>
    </div>
    <div class="flex items-center gap-4">
      <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg font-headline font-bold text-sm transition-all duration-300 hover:bg-rose-50 text-slate-600">Login</a>
      <a href="{{ route('register.hospital') }}" class="px-5 py-2 rounded-lg primary-gradient text-on-primary font-headline font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">Register</a>
    </div>
  </div>
</nav>

<main class="pt-24 pb-20 px-6 max-w-7xl mx-auto">
  <header class="mb-12 md:mb-20">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
      <div class="max-w-2xl">
        <span class="inline-block px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-[10px] font-bold uppercase tracking-widest mb-4">Partner Portal</span>
        <h1 class="text-4xl md:text-6xl font-headline font-black tracking-tight text-on-surface leading-none mb-6">
          Empowering Hospitals, <br/><span class="text-primary">Saving Lives.</span>
        </h1>
        <p class="text-lg text-on-secondary-container max-w-lg leading-relaxed">
          Join the LifeLink network to streamline blood supply management, coordinate emergency requests, and access real-time visibility across your region.
        </p>
      </div>
      <div class="flex gap-4">
        <div class="p-4 rounded-xl bg-surface-container-low ghost-border flex items-center gap-4">
          <div class="w-12 h-12 rounded-lg bg-tertiary-container flex items-center justify-center text-white">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified</span>
          </div>
          <div>
            <p class="text-xs font-bold text-on-secondary-fixed-variant uppercase tracking-tighter">Verified Network</p>
            <p class="text-sm font-medium text-on-surface">Trust-first hospital onboarding</p>
          </div>
        </div>
      </div>
    </div>
  </header>

  <form method="POST" action="{{ route('register.hospital.store') }}" class="grid grid-cols-1 md:grid-cols-12 gap-8">
    @csrf

    @if ($errors->any())
      <div class="md:col-span-12 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        Please review the highlighted hospital registration fields and try again.
      </div>
    @endif

    <section class="md:col-span-8 bg-surface-container-lowest rounded-xl p-8 shadow-sm ghost-border relative overflow-hidden">
      <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16"></div>
      <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
          <span class="material-symbols-outlined">domain</span>
        </div>
        <h2 class="text-2xl font-headline font-bold text-on-surface">Organization Details</h2>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="col-span-2">
          <label class="block text-xs font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-2 ml-1" for="hospital_name">Hospital Official Name</label>
          <input id="hospital_name" name="hospital_name" value="{{ old('hospital_name') }}" class="w-full bg-surface-container-low border-none rounded-lg p-4 text-on-surface focus:ring-4 focus:ring-primary-fixed/50 transition-all placeholder:text-slate-400" placeholder="e.g. St. Mary's General Hospital" type="text" required/>
          @error('hospital_name')<p class="mt-2 text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label class="block text-xs font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-2 ml-1" for="license_number">License ID / Registration No.</label>
          <input id="license_number" name="license_number" value="{{ old('license_number') }}" class="w-full bg-surface-container-low border-none rounded-lg p-4 text-on-surface focus:ring-4 focus:ring-primary-fixed/50 transition-all placeholder:text-slate-400" placeholder="HL-9920-X8" type="text" required/>
          @error('license_number')<p class="mt-2 text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label class="block text-xs font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-2 ml-1" for="facility_type">Facility Type</label>
          <select id="facility_type" class="w-full bg-surface-container-low border-none rounded-lg p-4 text-on-surface focus:ring-4 focus:ring-primary-fixed/50 transition-all" disabled aria-disabled="true">
            <option>Public General Hospital</option>
            <option>Private Medical Center</option>
            <option>Specialized Blood Bank</option>
            <option>Military Medical Facility</option>
          </select>
          <p class="mt-2 text-[11px] text-slate-500 ml-1">Facility classification can be added in the hospital profile after launch of advanced verification.</p>
        </div>

        <div class="col-span-2">
          <label class="block text-xs font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-2 ml-1" for="address">Physical Address</label>
          <textarea id="address" name="address" rows="3" class="w-full bg-surface-container-low border-none rounded-lg p-4 text-on-surface focus:ring-4 focus:ring-primary-fixed/50 transition-all placeholder:text-slate-400" placeholder="Street, Building, City, ZIP Code" required>{{ old('address') }}</textarea>
          @error('address')<p class="mt-2 text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
        </div>
      </div>
    </section>

    <section class="md:col-span-4 space-y-8">
      <div class="relative rounded-xl overflow-hidden h-64 shadow-lg">
        <img alt="Modern hospital lobby" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAoQp7pushxnbsRzm2KU7r12ZEGo14yKdAVhv_eukinsVvGT5izfNSY_0C-XuUhPYIVx_mdWhuvka_x3ij3If6_c6VlMoU3o-WXd01Y8dHCvOF0IyPWveEphEWQQi0XE_ey_LbjvdWu93RAwumTVXFMc1qfLhQx2CSR2k9mVzb3nWxQSsr2cie-ANFegCkdxq6BtVTSQJurnPJYUgc9883tyEWUC4DARtLPBe3Jbr9RGTcVvPj2uXvP_qyfkOFEKcAxm4Um9WrDrw"/>
        <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent flex items-end p-6">
          <p class="text-white font-headline font-bold text-lg leading-tight">Join 200+ healthcare facilities today.</p>
        </div>
      </div>

      <div class="bg-secondary-container/30 rounded-xl p-6 ghost-border">
        <h3 class="text-sm font-bold text-on-secondary-container mb-4 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary text-lg">info</span>
          Registration Benefits
        </h3>
        <ul class="space-y-3">
          <li class="flex gap-3 text-xs font-medium text-on-secondary-fixed-variant">
            <span class="material-symbols-outlined text-tertiary text-sm">check_circle</span>
            Instant match notifications
          </li>
          <li class="flex gap-3 text-xs font-medium text-on-secondary-fixed-variant">
            <span class="material-symbols-outlined text-tertiary text-sm">check_circle</span>
            Priority emergency logistics
          </li>
          <li class="flex gap-3 text-xs font-medium text-on-secondary-fixed-variant">
            <span class="material-symbols-outlined text-tertiary text-sm">check_circle</span>
            Regional inventory analytics
          </li>
        </ul>
      </div>
    </section>

    <section class="md:col-span-12 bg-surface-container-low rounded-xl p-8 flex flex-col md:flex-row gap-12 items-start">
      <div class="w-full md:w-1/3">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed">
            <span class="material-symbols-outlined">badge</span>
          </div>
          <h2 class="text-2xl font-headline font-bold text-on-surface">Admin Contact</h2>
        </div>
        <p class="text-sm text-on-secondary-container leading-relaxed">
          Designate the primary person responsible for account management and hospital communications within the LifeLink ecosystem.
        </p>
      </div>

      <div class="w-full md:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6 bg-surface-container-lowest p-8 rounded-xl shadow-sm">
        <div>
          <label class="block text-[10px] font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-1.5 ml-1" for="name">Full Name</label>
          <input id="name" name="name" value="{{ old('name') }}" class="w-full bg-surface-container-low border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="Dr. Sarah Chen" type="text" required autofocus autocomplete="name"/>
          @error('name')<p class="mt-2 text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label class="block text-[10px] font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-1.5 ml-1" for="email">Professional Email</label>
          <input id="email" name="email" value="{{ old('email') }}" class="w-full bg-surface-container-low border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="admin@hospital.org" type="email" required autocomplete="username"/>
          @error('email')<p class="mt-2 text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label class="block text-[10px] font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-1.5 ml-1" for="contact_phone">Direct Phone No.</label>
          <input id="contact_phone" class="w-full bg-surface-container-low border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="+1 (555) 000-0000" type="tel" disabled aria-disabled="true"/>
          <p class="mt-2 text-[11px] text-slate-500 ml-1">Phone capture can be added when hospital contact columns are introduced.</p>
        </div>

        <div>
          <label class="block text-[10px] font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-1.5 ml-1" for="designation">Designation</label>
          <input id="designation" class="w-full bg-surface-container-low border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="Head of Blood Services" type="text" disabled aria-disabled="true"/>
          <p class="mt-2 text-[11px] text-slate-500 ml-1">Role metadata is planned for the next hospital profile iteration.</p>
        </div>

        <div class="md:col-span-2">
          <label class="block text-[10px] font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-1.5 ml-1" for="password">Create Password</label>
          <div class="relative">
            <input id="password" name="password" class="w-full bg-surface-container-low border-none rounded-lg p-3 pr-12 text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="Create a secure password" type="password" required autocomplete="new-password"/>
            <button id="toggle-password" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary" aria-label="Toggle password visibility" aria-controls="password" aria-pressed="false">
              <span id="toggle-password-icon" class="material-symbols-outlined">visibility</span>
            </button>
          </div>
          @error('password')<p class="mt-2 text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
        </div>

        <div class="md:col-span-2">
          <label class="block text-[10px] font-bold text-on-secondary-fixed-variant uppercase tracking-widest mb-1.5 ml-1" for="password_confirmation">Confirm Password</label>
          <input id="password_confirmation" name="password_confirmation" class="w-full bg-surface-container-low border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="Repeat password" type="password" required autocomplete="new-password"/>
          @error('password_confirmation')<p class="mt-2 text-xs text-red-600 ml-1">{{ $message }}</p>@enderror
        </div>
      </div>
    </section>

    <div class="md:col-span-12 flex flex-col md:flex-row items-center justify-between gap-6 pt-8">
      <div class="flex items-center gap-4">
        <input class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" id="terms" type="checkbox" required/>
        <label class="text-sm text-on-secondary-container" for="terms">
          I agree to the <a class="text-primary font-bold hover:underline" href="#">LifeLink Partner Agreement</a> and privacy protocols.
        </label>
      </div>

      <div class="flex gap-4 w-full md:w-auto">
        <a href="{{ route('register') }}" class="flex-1 md:flex-none px-8 py-4 rounded-xl font-headline font-bold text-on-secondary-container hover:bg-surface-container-high transition-all text-center">Back to User Signup</a>
        <button class="flex-1 md:flex-none px-12 py-4 rounded-xl primary-gradient text-on-primary font-headline font-black text-lg shadow-xl shadow-primary/30 hover:translate-y-[-2px] active:translate-y-[1px] transition-all" type="submit">Complete Registration</button>
      </div>
    </div>
  </form>
</main>

<footer class="bg-slate-50 w-full py-12 px-6 border-t border-slate-200/10">
  <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-7xl mx-auto">
    <div class="col-span-1 md:col-span-1">
      <span class="text-lg font-bold text-slate-900 font-headline mb-4 block">LifeLink</span>
      <p class="text-xs text-slate-500 leading-relaxed">
        Connecting vital resources to those in need. Advanced logistical infrastructure for modern medicine.
      </p>
    </div>
    <div>
      <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-4">Platform</h4>
      <ul class="space-y-2">
        <li><a class="text-slate-400 hover:text-rose-500 text-xs transition-colors" href="#">Privacy Policy</a></li>
        <li><a class="text-slate-400 hover:text-rose-500 text-xs transition-colors" href="#">Terms of Service</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-4">Resources</h4>
      <ul class="space-y-2">
        <li><a class="text-slate-400 hover:text-rose-500 text-xs transition-colors" href="#">Global Directory</a></li>
        <li><a class="text-slate-400 hover:text-rose-500 text-xs transition-colors" href="#">Hospital Guidelines</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-4">Support</h4>
      <ul class="space-y-2">
        <li><a class="text-slate-400 hover:text-rose-500 text-xs transition-colors underline text-rose-600" href="#">Contact Support</a></li>
        <li><a class="text-slate-400 hover:text-rose-500 text-xs transition-colors" href="#">Knowledge Base</a></li>
      </ul>
    </div>
  </div>
  <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-slate-200/10 flex flex-col md:flex-row justify-between items-center gap-4">
    <p class="text-xs text-slate-500">© {{ date('Y') }} LifeLink Vital Pulse. All rights reserved.</p>
    <div class="flex gap-6">
      <span class="material-symbols-outlined text-slate-400">public</span>
      <span class="material-symbols-outlined text-slate-400">shield</span>
      <span class="material-symbols-outlined text-slate-400">monitoring</span>
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
