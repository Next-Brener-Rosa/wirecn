<div
    data-slot="command-list"
    role="listbox"
    {{ $attributes->class(cn(
        'no-scrollbar max-h-72 scroll-py-1 overflow-x-hidden overflow-y-auto outline-none',
    )) }}
>
    <template x-for="(group, gi) in groupedFiltered" :key="'cmd-group-' + gi">
        <div
            data-slot="command-group"
            role="group"
            class="{{ cn(
                'overflow-hidden p-1 text-foreground',
                '[&_.cmdk-group-heading]:px-2 [&_.cmdk-group-heading]:py-1.5 [&_.cmdk-group-heading]:text-xs [&_.cmdk-group-heading]:font-medium [&_.cmdk-group-heading]:text-muted-foreground',
            ) }}"
        >
            <div
                x-show="group.heading"
                x-text="group.heading"
                class="cmdk-group-heading"
            ></div>
            <template x-for="item in group.items" :key="item.value + String(item._flatIndex)">
                <div
                    role="option"
                    data-slot="command-item"
                    class="{{ cn(
                        'group/command-item relative flex cursor-default items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none select-none',
                        'in-data-[slot=dialog-content]:rounded-lg!',
                        'data-[disabled=true]:pointer-events-none data-[disabled=true]:opacity-50',
                        'data-[selected=true]:bg-muted data-[selected=true]:text-foreground',
                        '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4',
                        'data-[selected=true]:[&_svg]:text-foreground',
                    ) }}"
                    x-bind:data-selected="item._flatIndex === activeIndex ? 'true' : null"
                    x-bind:data-checked="item._flatIndex === activeIndex ? 'true' : null"
                    x-bind:aria-selected="item._flatIndex === activeIndex ? 'true' : 'false'"
                    x-on:mouseenter="activeIndex = item._flatIndex"
                    x-on:click="selectItem(item)"
                >
                    <span class="min-w-0 flex-1 truncate" x-text="item.label"></span>
                    <span
                        x-show="item.shortcut"
                        x-cloak
                        data-slot="command-shortcut"
                        class="{{ cn(
                            'ml-auto text-xs tracking-widest text-muted-foreground',
                            'group-data-[selected=true]/command-item:text-foreground',
                        ) }}"
                        x-text="item.shortcut"
                    ></span>
                    <x-livecn.phosphor-icon name="check"
                        x-show="!item.shortcut"
                        x-cloak
                        class="{{ cn(
                            'ml-auto size-4 shrink-0 opacity-0 transition-opacity',
                            'group-data-[checked=true]/command-item:opacity-100',
                        ) }}"
                    />
                </div>
            </template>
        </div>
    </template>
    {{ $slot }}
</div>
