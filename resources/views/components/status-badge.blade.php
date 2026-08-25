@props(['status'])

@php
    $colorClass = match ($status->color()) {
        'primary' => 'bg-primary-50 text-primary-700 ring-primary-600/20',
        'surface' => 'bg-surface-50 text-surface-700 ring-surface-600/20',
        'danger' => 'bg-danger-50 text-danger-700 ring-danger-600/20',
        'success' => 'bg-success-50 text-success-700 ring-success-600/20',
        'warning' => 'bg-warning-50 text-warning-700 ring-warning-600/20',
        default => 'bg-surface-50 text-surface-700 ring-surface-600/20',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset ' . $colorClass]) }}>
    {{ $status->label() }}
</span>
