<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-white shadow-sm hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-300 focus:ring-offset-2 disabled:opacity-60']) }}>
    {{ $slot }}
</button>
