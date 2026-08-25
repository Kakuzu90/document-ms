@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-primary-700 bg-primary-50 rounded-lg transition-colors duration-200'
        : 'flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-surface-600 hover:text-surface-800 hover:bg-surface-100 rounded-lg transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
