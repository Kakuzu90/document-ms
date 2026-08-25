@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg text-primary-700 bg-primary-50 transition-all duration-200'
        : 'inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
