@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-xl border border-rose-200 bg-rose-50 px-3 py-1.5 text-sm font-semibold text-rose-700 shadow-sm'
            : 'inline-flex items-center rounded-xl border border-transparent px-3 py-1.5 text-sm font-medium text-slate-600 hover:border-rose-100 hover:bg-white hover:text-rose-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
