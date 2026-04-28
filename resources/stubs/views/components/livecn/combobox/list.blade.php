<div
    data-slot="combobox-list"
    role="listbox"
    x-bind:id="listId"
    {{ $attributes->class(cn(
        'max-h-60 scroll-py-1 overflow-y-auto overscroll-contain p-1',
    )) }}
>
    <template x-for="(item, index) in filtered" x-bind:key="String(item.value) + '-' + index">
        <div
            role="option"
            x-bind:aria-selected="(selectedValue === item.value).toString()"
            class="{{ cn(
                'relative flex w-full cursor-default items-center gap-2 rounded-md py-1 pr-8 pl-1.5 text-sm outline-hidden select-none',
                '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4',
            ) }}"
            x-bind:class="index === activeIndex ? 'bg-accent text-accent-foreground' : ''"
            x-on:mouseenter="activeIndex = index"
            x-on:mousedown.prevent="selectIndex(index)"
        >
            <span class="min-w-0 flex-1 truncate" x-text="item.label"></span>
            <span
                class="pointer-events-none absolute right-2 flex size-4 items-center justify-center text-foreground"
                x-show="selectedValue === item.value"
                x-cloak
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="size-4 shrink-0" aria-hidden="true">
                    <path
                        d="M229.66 77.66l-128 128a8 8 0 0 1-11.32 0l-56-56a8 8 0 0 1 11.32-11.32L96 188.69 218.34 66.34a8 8 0 0 1 11.32 11.32Z"
                    />
                </svg>
            </span>
        </div>
    </template>
    {{ $slot }}
</div>
