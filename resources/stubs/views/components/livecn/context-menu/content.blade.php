<div
    role="menu"
    tabindex="-1"
    data-slot="context-menu-content"
    {{ $attributes->class(cn(
        'z-50 max-h-[min(24rem,calc(100dvh-1rem))] min-w-36 origin-top-left overflow-x-hidden overflow-y-auto rounded-lg bg-popover p-1 text-popover-foreground shadow-md ring-1 ring-foreground/10 duration-100 outline-none',
    )) }}
>
    {{ $slot }}
</div>
