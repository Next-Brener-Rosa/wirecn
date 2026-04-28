<x-livecn.hover-card.portal>
    <div
        x-ref="floating"
        x-show="open"
        x-cloak
        x-transition
        role="region"
        data-slot="hover-card-content"
        x-on:mouseenter="cancelHide()"
        x-on:mouseleave="hide()"
        x-bind:data-open="open ? '' : null"
        {{ $attributes->class(cn(
            'z-50 w-64 origin-top-left rounded-lg bg-popover p-2.5 text-sm text-popover-foreground shadow-md ring-1 ring-foreground/10 outline-none duration-100',
            'data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95',
            'data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95',
        )) }}
    >
        {{ $slot }}
    </div>
</x-livecn.hover-card.portal>
