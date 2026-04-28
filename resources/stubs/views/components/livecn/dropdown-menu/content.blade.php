<x-livecn.dropdown-menu.portal>
    <div
        x-ref="floating"
        x-show="open"
        x-cloak
        x-transition
        role="menu"
        tabindex="-1"
        data-slot="dropdown-menu-content"
        data-testid="dropdown-menu"
        x-bind:data-open="open ? '' : null"
        {{ $attributes->class(cn(
            'z-50 max-h-[min(24rem,calc(100dvh-1rem))] min-w-32 w-max max-w-[calc(100vw-2rem)] origin-top-left overflow-x-hidden overflow-y-auto rounded-lg bg-popover p-1 text-popover-foreground shadow-md ring-1 ring-foreground/10 duration-100 outline-none',
            'data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95',
            'data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95',
        )) }}
    >
        {{ $slot }}
    </div>
</x-livecn.dropdown-menu.portal>
