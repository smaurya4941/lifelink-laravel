@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-xl border-slate-300 bg-white/90 text-slate-900 shadow-sm focus:border-rose-300 focus:ring-rose-200']) }}>
