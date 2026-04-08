<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>Update Profile | LifeLink</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "surface-container-highest": "#d3e4fe",
        "on-primary": "#ffffff",
        "primary-fixed-dim": "#ffb3b6",
        "outline-variant": "#e5bdbe",
        "outline": "#906f70",
        "secondary": "#515f74",
        "primary-container": "#e11d48",
        "tertiary-fixed-dim": "#4edea3",
        "secondary-fixed-dim": "#b9c7df",
        "primary": "#b80035",
        "surface-variant": "#d3e4fe",
        "on-background": "#0b1c30",
        "inverse-primary": "#ffb3b6",
        "secondary-container": "#d5e3fc",
        "primary-fixed": "#ffdada",
        "on-secondary-fixed": "#0d1c2e",
        "tertiary": "#006847",
        "on-tertiary-fixed": "#002113",
        "on-tertiary": "#ffffff",
        "on-secondary": "#ffffff",
        "on-primary-fixed": "#40000c",
        "surface-container-high": "#dce9ff",
        "inverse-surface": "#213145",
        "surface-container-lowest": "#ffffff",
        "on-error": "#ffffff",
        "on-tertiary-container": "#eefff3",
        "error-container": "#ffdad6",
        "tertiary-fixed": "#6ffbbe",
        "background": "#f8f9ff",
        "surface-dim": "#cbdbf5",
        "on-error-container": "#93000a",
        "surface-bright": "#f8f9ff",
        "inverse-on-surface": "#eaf1ff",
        "surface-container": "#e5eeff",
        "on-secondary-fixed-variant": "#3a485b",
        "on-primary-container": "#fffaf9",
        "tertiary-container": "#00845a",
        "on-surface-variant": "#5c3f40",
        "on-surface": "#0b1c30",
        "on-secondary-container": "#57657a",
        "error": "#ba1a1a",
        "on-tertiary-fixed-variant": "#005236",
        "surface": "#f8f9ff",
        "surface-tint": "#be0037",
        "secondary-fixed": "#d5e3fc",
        "on-primary-fixed-variant": "#920028",
        "surface-container-low": "#eff4ff"
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
input:focus, textarea:focus, select:focus {
  outline: none !important;
  border-color: transparent !important;
  box-shadow: 0 0 0 2px #ffdada80 !important;
}
</style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">
@php
  $profileUser = auth()->user();
  $bloodGroupValue = old('blood_group', $donorProfile->blood_group ?? $recipientProfile->blood_group);
  $ageValue = old('age', $donorProfile->age ?? $recipientProfile->age);
  $weightValue = old('weight', $donorProfile->weight ?? $recipientProfile->weight);
  $heightValue = old('height', $donorProfile->height);
  $emergencyContactValue = old('emergency_contact', $donorProfile->emergency_contact ?? $recipientProfile->emergency_contact);
  $recipientConditionValue = old('recipient_medical_condition', $recipientProfile->medical_condition);
@endphp

<header class="fixed top-0 z-50 flex w-full items-center justify-between bg-white/80 px-6 py-3 font-headline tracking-tight shadow-sm backdrop-blur-xl">
  <div class="text-2xl font-bold tracking-tighter text-rose-700">LifeLink</div>
  <div class="flex items-center gap-4">
    <a href="{{ route('notifications.index') }}" class="rounded-full p-2 text-slate-600 transition-all hover:bg-rose-50">
      <span class="material-symbols-outlined">notifications</span>
    </a>
    <a href="{{ route('security.dashboard') }}" class="rounded-full p-2 text-slate-600 transition-all hover:bg-rose-50">
      <span class="material-symbols-outlined">help_outline</span>
    </a>
    <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full border-2 border-primary-fixed bg-primary-fixed text-sm font-bold text-on-primary-fixed-variant">
      {{ strtoupper(substr($profileUser->name, 0, 1)) }}
    </div>
  </div>
</header>

<aside class="fixed left-0 top-0 flex h-screen w-64 flex-col gap-2 bg-slate-50 py-6 pt-20 font-headline text-sm font-medium">
  <div class="mb-8 px-6">
    <h2 class="text-lg font-extrabold text-slate-900">The Vital Pulse</h2>
    <p class="text-xs font-normal text-slate-500">Blood Management Portal</p>
  </div>
  <nav class="flex-1 space-y-1">
    <a class="mx-2 flex items-center rounded-xl px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('dashboard') }}">
      <span class="material-symbols-outlined mr-3">dashboard</span>
      Dashboard
    </a>
    <a class="mx-2 flex items-center rounded-xl bg-white px-4 py-3 text-rose-700 shadow-sm transition-transform duration-200 hover:translate-x-1" href="{{ route('profile.edit') }}">
      <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' 1;">person</span>
      Profile
    </a>
    @if($profileUser->hasCapability('donor'))
      <a class="mx-2 flex items-center rounded-xl px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('matches.index') }}">
        <span class="material-symbols-outlined mr-3">opacity</span>
        Donations
      </a>
    @endif
    @if($profileUser->hasCapability('recipient'))
      <a class="mx-2 flex items-center rounded-xl px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('requests.index') }}">
        <span class="material-symbols-outlined mr-3">volunteer_activism</span>
        Requests
      </a>
    @endif
    <a class="mx-2 flex items-center rounded-xl px-4 py-3 text-slate-500 transition-transform duration-200 hover:translate-x-1 hover:bg-slate-100" href="{{ route('security.dashboard') }}">
      <span class="material-symbols-outlined mr-3">settings</span>
      Settings
    </a>
  </nav>
  <div class="mb-6 px-4">
    <a href="{{ $profileUser->hasCapability('recipient') ? route('requests.create') : route('map.index') }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 py-3 font-bold text-on-primary shadow-sm transition-all active:scale-95">
      <span class="material-symbols-outlined text-sm">emergency</span>
      Request Emergency
    </a>
  </div>
  <div class="border-t border-slate-200 pt-4">
    <a class="mx-2 flex items-center rounded-xl px-4 py-3 text-slate-500 transition-all hover:bg-slate-100" href="{{ route('notifications.index') }}">
      <span class="material-symbols-outlined mr-3">contact_support</span>
      Support
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="mx-2 flex w-[calc(100%-1rem)] items-center rounded-xl px-4 py-3 text-slate-500 transition-all hover:bg-slate-100" type="submit">
        <span class="material-symbols-outlined mr-3">logout</span>
        Sign Out
      </button>
    </form>
  </div>
</aside>

<main class="ml-64 max-w-6xl px-8 pb-20 pt-24">
  @if(session('status'))
    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
  @endif

  @if(session('error'))
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ session('error') }}</div>
  @endif

  <div class="mb-10">
    <h1 class="mb-2 font-headline text-4xl font-extrabold tracking-tight text-on-surface">Update Profile</h1>
    <p class="font-medium text-secondary">Keep your medical and contact information current for life-saving matches.</p>
  </div>

  <form id="profile-update-form" method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')
    <input type="hidden" name="is_donor" value="0">
    <input type="hidden" name="is_recipient" value="0">
    <input type="hidden" name="country" value="{{ old('country', $user->country ?? 'India') }}">

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
      <div class="space-y-8 lg:col-span-8">
        <section class="rounded-xl bg-surface-container-lowest p-8 shadow-sm">
          <div class="mb-8 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-fixed">
              <span class="material-symbols-outlined text-primary">badge</span>
            </div>
            <h3 class="font-headline text-xl font-bold">Core Profile</h3>
          </div>

          <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Full Name</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="text" name="name" value="{{ old('name', $user->name) }}" required/>
              @error('name')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Email Address</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="email" name="email" value="{{ old('email', $user->email) }}" required/>
              @error('email')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Phone Number</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"/>
              @error('phone_number')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Date of Birth</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}"/>
              @error('date_of_birth')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5 md:col-span-2">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Physical Address</label>
              <textarea class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" rows="3" name="address">{{ old('address', $user->address) }}</textarea>
              @error('address')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Blood Group</label>
              <select class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" name="blood_group">
                <option value="">Select blood group</option>
                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                  <option value="{{ $group }}" @selected($bloodGroupValue === $group)>{{ $group }}</option>
                @endforeach
              </select>
              @error('blood_group')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Emergency Contact</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="text" name="emergency_contact" value="{{ $emergencyContactValue }}"/>
              @error('emergency_contact')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
          </div>

          <div class="mt-6 grid grid-cols-3 gap-4">
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Age</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-center text-on-surface" type="number" name="age" value="{{ $ageValue }}"/>
              @error('age')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Weight (kg)</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-center text-on-surface" type="number" name="weight" value="{{ $weightValue }}"/>
              @error('weight')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Height (cm)</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-center text-on-surface" type="number" name="height" value="{{ $heightValue }}"/>
              @error('height')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
          </div>

          <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">City</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="text" name="city" value="{{ old('city', $user->city) }}"/>
              @error('city')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">State</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="text" name="traditional_state" value="{{ old('traditional_state', $user->traditional_state) }}"/>
              @error('traditional_state')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Pincode</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="text" name="pincode" value="{{ old('pincode', $user->pincode) }}"/>
              @error('pincode')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
          </div>
        </section>

        <section class="rounded-xl bg-surface-container-lowest p-8 shadow-sm">
          <div class="mb-8 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-tertiary-fixed">
              <span class="material-symbols-outlined text-tertiary">volunteer_activism</span>
            </div>
            <h3 class="font-headline text-xl font-bold">Donor Preferences</h3>
          </div>

          <div class="mb-8 grid grid-cols-1 gap-8 md:grid-cols-2">
            <div class="space-y-4">
              <label class="flex items-center justify-between rounded-xl bg-surface p-4">
                <span class="text-sm font-semibold">Available as Donor</span>
                <input class="h-5 w-5 rounded border-none bg-surface-container-high text-primary focus:ring-primary-fixed" type="checkbox" name="is_donor" value="1" @checked(old('is_donor', $user->is_donor))/>
              </label>
              <label class="flex items-center justify-between rounded-xl bg-surface p-4">
                <span class="text-sm font-semibold">Actively Accepting Matches</span>
                <input class="h-5 w-5 rounded border-none bg-surface-container-high text-primary focus:ring-primary-fixed" type="checkbox" name="availability_status" value="1" @checked(old('availability_status', $donorProfile->availability_status))/>
              </label>
            </div>
            <div class="space-y-4">
              <label class="flex items-center justify-between rounded-xl bg-surface p-4">
                <span class="text-sm font-semibold">Can Request Blood</span>
                <input class="h-5 w-5 rounded border-none bg-surface-container-high text-primary focus:ring-primary-fixed" type="checkbox" name="is_recipient" value="1" @checked(old('is_recipient', $user->is_recipient))/>
              </label>
              <label class="flex items-center justify-between rounded-xl bg-surface p-4">
                <span class="text-sm font-semibold">Share Live Location</span>
                <input id="is_live_location_enabled" class="h-5 w-5 rounded border-none bg-surface-container-high text-primary focus:ring-primary-fixed" type="checkbox" name="is_live_location_enabled" value="1" @checked(old('is_live_location_enabled', $donorProfile->is_live_location_enabled))/>
              </label>
            </div>
          </div>

          @error('is_donor')<p class="mb-4 text-xs text-red-600">{{ $message }}</p>@enderror

          <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Last Donation Date</label>
              <input class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="date" name="last_donation_date" value="{{ old('last_donation_date', $donorProfile->last_donation_date) }}"/>
              @error('last_donation_date')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5 md:col-span-2">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Medical Conditions (Donor)</label>
              <textarea class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" rows="2" name="medical_conditions" placeholder="e.g. Hypertension, Diabetes, None">{{ old('medical_conditions', $donorProfile->medical_conditions) }}</textarea>
              @error('medical_conditions')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
          </div>
        </section>

        <section class="rounded-xl bg-surface-container-lowest p-8 shadow-sm">
          <div class="mb-8 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-secondary-fixed">
              <span class="material-symbols-outlined text-secondary">lock</span>
            </div>
            <h3 class="font-headline text-xl font-bold">Update Password</h3>
          </div>
          <p class="text-sm text-secondary">Manage your account security and update your password.</p>
          <div class="grid grid-cols-1 gap-6 border-t border-slate-100 pt-6 md:grid-cols-3">
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Current Password</label>
              <input form="password-update-form" class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="password" name="current_password" autocomplete="current-password"/>
              @if($errors->updatePassword->get('current_password'))
                <p class="text-xs text-red-600">{{ $errors->updatePassword->first('current_password') }}</p>
              @endif
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">New Password</label>
              <input form="password-update-form" class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="password" name="password" autocomplete="new-password"/>
              @if($errors->updatePassword->get('password'))
                <p class="text-xs text-red-600">{{ $errors->updatePassword->first('password') }}</p>
              @endif
            </div>
            <div class="space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Confirm New Password</label>
              <input form="password-update-form" class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="password" name="password_confirmation" autocomplete="new-password"/>
              @if($errors->updatePassword->get('password_confirmation'))
                <p class="text-xs text-red-600">{{ $errors->updatePassword->first('password_confirmation') }}</p>
              @endif
            </div>
          </div>
          <div class="flex justify-end pt-4">
            <button form="password-update-form" class="flex items-center gap-2 rounded-xl bg-slate-900 px-8 py-2.5 font-bold text-on-primary shadow-sm transition-all hover:brightness-110 active:scale-95" type="submit">
              <span class="material-symbols-outlined text-lg">lock_reset</span>
              Update Password
            </button>
          </div>
        </section>

        <section class="mt-8 rounded-xl bg-surface-container-lowest p-8 shadow-sm">
          <div class="mb-6 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-error-container">
              <span class="material-symbols-outlined text-error">delete_forever</span>
            </div>
            <h3 class="font-headline text-xl font-bold text-on-surface">Delete Account</h3>
          </div>
          <div class="mb-8 max-w-2xl">
            <p class="text-sm leading-relaxed text-secondary">
              Once your account is deleted, all of your resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
            </p>
          </div>
          <div class="space-y-4">
            <div class="max-w-md space-y-1.5">
              <label class="ml-1 text-xs font-bold uppercase tracking-wider text-slate-500">Confirm Password</label>
              <input form="delete-account-form" class="w-full rounded-xl border-none bg-surface-container-low px-4 py-3 text-on-surface" type="password" name="password" placeholder="Enter password to confirm"/>
              @if($errors->userDeletion->get('password'))
                <p class="text-xs text-red-600">{{ $errors->userDeletion->first('password') }}</p>
              @endif
            </div>
            <div>
              <button form="delete-account-form" class="rounded-lg bg-error px-8 py-3 text-sm font-bold uppercase tracking-wider text-on-error shadow-lg shadow-error/20 transition-all hover:bg-red-700 active:scale-95" type="submit">
                Delete Account
              </button>
            </div>
          </div>
        </section>
      </div>

      <div class="space-y-8 lg:col-span-4">
        <div class="rounded-xl bg-surface-container-high p-6">
          <div class="mb-4 flex items-center gap-3">
            <span class="material-symbols-outlined text-rose-600">medical_information</span>
            <h4 class="font-bold">Recipient Needs</h4>
          </div>
          <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Medical Conditions</label>
          <textarea class="mt-2 w-full rounded-xl border-none bg-surface-container-lowest px-4 py-3 text-sm text-on-surface" rows="4" name="recipient_medical_condition">{{ $recipientConditionValue }}</textarea>
          @error('recipient_medical_condition')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
          <p class="mt-2 text-[10px] leading-relaxed text-slate-500">This information helps healthcare providers prepare for your request before arrival.</p>
        </div>

        <div class="overflow-hidden rounded-xl bg-surface-container-lowest p-6 shadow-sm">
          <div class="mb-6 flex items-center justify-between">
            <h4 class="flex items-center gap-2 font-bold">
              <span class="material-symbols-outlined text-primary">location_on</span>
              Location Services
            </h4>
          </div>

          @include('partials.location-picker', [
            'uid' => 'profile_location_ui',
            'label' => 'Current Location',
            'helpText' => 'Location is used for nearby donor discovery and request matching.',
            'buttonText' => 'Update Current Location',
            'latName' => 'latitude',
            'lngName' => 'longitude',
            'latId' => 'profile_latitude',
            'lngId' => 'profile_longitude',
            'latValue' => $user->latitude,
            'lngValue' => $user->longitude,
            'requireWhenCheckboxId' => 'is_live_location_enabled',
          ])

          <input type="hidden" name="current_latitude" value="{{ old('current_latitude', $donorProfile->current_latitude ?? $user->latitude) }}">
          <input type="hidden" name="current_longitude" value="{{ old('current_longitude', $donorProfile->current_longitude ?? $user->longitude) }}">

          <div class="mt-6 grid grid-cols-2 gap-4">
            <div class="rounded-lg bg-surface p-3 text-center">
              <p class="text-[10px] font-bold uppercase text-slate-500">Latitude</p>
              <p class="text-sm font-mono font-bold">{{ old('latitude', $user->latitude ?? 'Not set') }}</p>
            </div>
            <div class="rounded-lg bg-surface p-3 text-center">
              <p class="text-[10px] font-bold uppercase text-slate-500">Longitude</p>
              <p class="text-sm font-mono font-bold">{{ old('longitude', $user->longitude ?? 'Not set') }}</p>
            </div>
          </div>
        </div>

        <div class="flex items-center gap-4 rounded-xl bg-tertiary-container p-6 text-on-tertiary-container">
          <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10">
            <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">verified</span>
          </div>
          <div>
            <p class="font-bold leading-tight">{{ $user->is_donor ? 'Verified Donor' : 'Active Member' }}</p>
            <p class="text-xs opacity-80">
              @if($donorProfile->last_donation_date)
                Last donation: {{ \Illuminate\Support\Carbon::parse($donorProfile->last_donation_date)->format('M Y') }}
              @else
                Keep your profile updated for stronger matches.
              @endif
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-12 flex items-center justify-end gap-4 border-t border-slate-200 pt-8">
      <a href="{{ route('profile.edit') }}" class="rounded-xl px-8 py-3 font-bold text-slate-500 transition-all hover:bg-slate-100 active:scale-95">
        Discard Changes
      </a>
      <button class="flex items-center gap-3 rounded-xl bg-slate-900 px-10 py-3 font-bold text-on-primary shadow-sm transition-all hover:brightness-110 active:scale-95" type="submit">
        <span class="material-symbols-outlined">save</span>
        Save Profile
      </button>
    </div>
  </form>
</main>

<form id="password-update-form" method="POST" action="{{ route('password.update') }}">
  @csrf
  @method('PUT')
</form>

<form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
  @csrf
  @method('DELETE')
</form>

<footer class="ml-64 mt-auto flex w-auto max-w-7xl flex-col justify-between px-12 py-8 text-xs text-slate-500 md:flex-row">
  <div class="mb-4 md:mb-0">Â© {{ date('Y') }} LifeLink Health. All rights reserved.</div>
  <div class="flex gap-8">
    <a class="text-slate-400 transition-colors hover:text-rose-500" href="#">Privacy Policy</a>
    <a class="text-slate-400 transition-colors hover:text-rose-500" href="#">Terms of Service</a>
    <a class="text-slate-400 transition-colors hover:text-rose-500" href="#">Donor Guidelines</a>
    <a class="text-slate-400 transition-colors hover:text-rose-500" href="#">Contact Support</a>
  </div>
</footer>
</body>
</html>


