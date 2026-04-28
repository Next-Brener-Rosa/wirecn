<div
    x-ref="subFloating"
    x-show="open"
    x-cloak
    x-transition.opacity
    role="menu"
    tabindex="-1"
    data-slot="context-menu-sub-content"
    x-on:mouseenter="keepOpen()"
    x-on:mouseleave="scheduleClose()"
    {{ $attributes->class(cn(
        'z-50 max-h-[min(24rem,calc(100dvh-1rem))] min-w-36 overflow-x-hidden overflow-y-auto rounded-lg bg-popover p-1 text-popover-foreground shadow-lg ring-1 ring-foreground/10 outline-none',
    )) }}
>
    {{ $slot }}
</div>
