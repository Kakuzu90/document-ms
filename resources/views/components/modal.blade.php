@props(['name', 'show' => false, 'maxWidth' => '2xl', 'focusable' => false])

@php
    $maxWidthClass = match ($maxWidth) {
        'sm'  => 'sm:max-w-sm',
        'md'  => 'sm:max-w-md',
        'lg'  => 'sm:max-w-lg',
        'xl'  => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        default => 'sm:max-w-2xl',
    };
@endphp

<div
    x-data="{
        show: @js($show),
        focusables() {
            return [...$el.querySelectorAll('a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])')];
        },
        firstFocusable()  { return this.focusables()[0]; },
        lastFocusable()   { return this.focusables().slice(-1)[0]; },
        nextFocusable()   { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable(); },
        prevFocusable()   { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable(); },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1); },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1; },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            {{ $focusable ? 'setTimeout(() => firstFocusable()?.focus(), 100)' : '' }}
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable()?.focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable()?.focus()"
    x-show="show"
    class="fixed inset-0 z-[60] overflow-y-auto"
    style="display: {{ $show ? '' : 'none' }};"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-surface-900/40 backdrop-blur-sm"
        x-on:click="show = false"
    ></div>

    {{-- Modal panel --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="
            flex min-h-full items-center justify-center p-4
        "
    >
        <div class="
            relative w-full {{ $maxWidthClass }}
            bg-white rounded-2xl
            shadow-xl
            overflow-hidden
        ">
            {{ $slot }}
        </div>
    </div>
</div>
