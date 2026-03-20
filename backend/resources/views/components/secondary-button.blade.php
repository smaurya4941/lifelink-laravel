<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center rounded-xl border border-rose-200 bg-white px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-rose-700 hover:bg-rose-50 focus:outline-none focus:ring-2 focus:ring-rose-200 focus:ring-offset-2 disabled:opacity-25']) }}>
    {{ $slot }}
</button>
