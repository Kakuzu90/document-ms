<a {{ $attributes->merge([
    'class' => '
        flex items-center gap-2.5
        px-4 py-2
        text-sm text-surface-600
        hover:bg-surface-50 hover:text-surface-800
        transition-colors duration-150
    '
]) }}>
    {{ $slot }}
</a>
