@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-start text-sm font-semibold text-rose-700'
            : 'block w-full rounded-lg border border-transparent px-3 py-2 text-start text-sm font-medium text-slate-600 hover:border-rose-100 hover:bg-white hover:text-rose-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
