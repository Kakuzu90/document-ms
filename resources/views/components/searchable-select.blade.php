@props(['options' => [], 'name' => '', 'id' => '', 'value' => '', 'placeholder' => 'Select an option...', 'searchable' => true])

<div
    x-data="{
        open: false,
        search: '',
        value: @js($value),
        options: @js($options),
        get filteredOptions() {
            if (this.search === '') {
                return this.options;
            }
            return this.options.filter(option => 
                option.label.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        get selectedOption() {
            return this.options.find(option => option.value === this.value);
        },
        select(option) {
            this.value = option.value;
            this.open = false;
        }
    }"
    @click.outside="open = false"
    @focusout="if (!$el.contains($event.relatedTarget)) open = false"
    @keydown.escape.window="open = false"
    class="relative"
>
    <!-- Hidden input for form submission -->
    <input type="hidden" name="{{ $name }}" :value="value">

    <!-- Trigger -->
    <button
        type="button"
        id="{{ $id }}"
        @click="open = !open; if(open) $nextTick(() => $refs.searchInput.focus())"
        class="form-input flex items-center justify-between w-full text-left bg-white"
        :class="{ 'ring-2 ring-primary-500 border-primary-500': open }"
    >
        <span x-text="selectedOption ? selectedOption.label : '{{ $placeholder }}'"
              :class="!selectedOption ? 'text-surface-400' : 'text-surface-900'">
        </span>
        <svg class="w-4 h-4 text-surface-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
        class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-lg border border-surface-200 overflow-hidden"
        style="display: none;"
    >
        <!-- Search Input -->
        @if($searchable)
        <div class="p-2 border-b border-surface-100 bg-surface-50/50">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    x-ref="searchInput"
                    type="text"
                    x-model="search"
                    placeholder="Search..."
                    class="w-full pl-9 pr-3 py-1.5 text-sm bg-white border border-surface-200 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors"
                >
            </div>
        </div>
        @endif

        <!-- Options List -->
        <ul class="max-h-60 overflow-y-auto py-1">
            <template x-for="option in filteredOptions" :key="option.value">
                <li
                    @click="select(option)"
                    class="px-3 py-2 text-sm cursor-pointer transition-colors flex items-center justify-between"
                    :class="value === option.value ? 'bg-primary-50 text-primary-700 font-medium' : 'text-surface-700 hover:bg-surface-50'"
                >
                    <span x-text="option.label"></span>
                    <svg x-show="value === option.value" class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </li>
            </template>
            <li x-show="filteredOptions.length === 0" class="px-3 py-3 text-sm text-center text-surface-500">
                No options found
            </li>
        </ul>
    </div>
</div>
