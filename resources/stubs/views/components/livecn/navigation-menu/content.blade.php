<div
    data-slot="navigation-menu-content"
    x-init="registerPanel($el.closest('[data-nav-item-id]').dataset.navItemId, $el)"
    x-show="openId === $el.closest('[data-nav-item-id]').dataset.navItemId"
    x-bind:data-open="openId === $el.closest('[data-nav-item-id]').dataset.navItemId ? '' : null"
    x-on:mouseenter="triggerOnHover && cancelHoverClose()"
    x-on:mouseleave="triggerOnHover && scheduleHoverClose()"
    x-cloak
    x-transition
    {{ $attributes->class(cn(
        'absolute left-0 top-full z-50',
        'data-ending-style:data-activation-direction=left:translate-x-[50%] data-ending-style:data-activation-direction=right:translate-x-[-50%]',
        'data-starting-style:data-activation-direction=left:translate-x-[-50%] data-starting-style:data-activation-direction=right:translate-x-[50%]',
        'h-auto min-h-0 w-auto p-1 transition-[opacity,transform,translate] duration-[0.35s] ease-[cubic-bezier(0.22,1,0.36,1)]',
        'group-data-[viewport=false]/navigation-menu:rounded-lg group-data-[viewport=false]/navigation-menu:bg-popover group-data-[viewport=false]/navigation-menu:text-popover-foreground group-data-[viewport=false]/navigation-menu:shadow group-data-[viewport=false]/navigation-menu:ring-1 group-data-[viewport=false]/navigation-menu:ring-foreground/10 group-data-[viewport=false]/navigation-menu:duration-300',
        'data-ending-style:opacity-0 data-starting-style:opacity-0',
        'data-[motion=from-end]:slide-in-from-right-52 data-[motion=from-start]:slide-in-from-left-52 data-[motion=to-end]:slide-out-to-right-52 data-[motion=to-start]:slide-out-to-left-52',
        'data-[motion^=from-]:animate-in data-[motion^=from-]:fade-in data-[motion^=to-]:animate-out data-[motion^=to-]:fade-out',
        '**:data-[slot=navigation-menu-link]:focus:ring-0 **:data-[slot=navigation-menu-link]:focus:outline-none',
        'group-data-[viewport=false]/navigation-menu:data-open:animate-in group-data-[viewport=false]/navigation-menu:data-open:fade-in-0 group-data-[viewport=false]/navigation-menu:data-open:zoom-in-95',
        'group-data-[viewport=false]/navigation-menu:data-closed:animate-out group-data-[viewport=false]/navigation-menu:data-closed:fade-out-0 group-data-[viewport=false]/navigation-menu:data-closed:zoom-out-95',
        'z-50 min-w-[12rem] rounded-lg bg-popover text-popover-foreground shadow ring-1 ring-foreground/10 outline-none',
    )) }}
>
    {{ $slot }}
</div>
