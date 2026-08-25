@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1'])

@php
    $alignmentClasses = match ($align) {
        'left'  => 'origin-top-left left-0',
        'right' => 'origin-top-right right-0',
        default => 'origin-top-right right-0',
    };

    $widthClass = match ($width) {
        '48' => 'w-48',
        '60' => 'w-60',
        default => 'w-48',
    };
@endphp

<div
    class="relative"
    x-data="{ open: false }"
    @click.outside="open = false"
    @close.stop="open = false"
>
    {{-- Trigger --}}
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    {{-- Content --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
        class="
            absolute z-50 mt-2
            {{ $widthClass }}
            {{ $alignmentClasses }}
            rounded-xl
            bg-white/95 backdrop-blur-xl
            border border-surface-200/80
            shadow-lg
            ring-1 ring-black/[0.03]
            overflow-hidden
        "
        style="display: none;"
        @click="open = false"
    >
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
