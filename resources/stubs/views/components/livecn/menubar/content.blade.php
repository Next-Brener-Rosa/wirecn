<x-livecn.menubar.portal>
    <div
        x-ref="floating"
        x-show="open"
        x-cloak
        x-transition
        role="menu"
        tabindex="-1"
        data-slot="menubar-content"
        data-testid="menubar-content"
        x-bind:data-open="open ? '' : null"
        {{ $attributes->class(cn(
            'z-50 max-h-[min(24rem,calc(100dvh-1rem))] min-w-36 w-max max-w-[calc(100vw-2rem)] origin-top-left overflow-x-hidden overflow-y-auto rounded-lg bg-popover p-1 text-popover-foreground shadow-md ring-1 ring-foreground/10 duration-100 outline-none',
            'data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95',
            'data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95',
            'data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2',
        )) }}
    >
        {{ $slot }}
    </div>
</x-livecn.menubar.portal>
