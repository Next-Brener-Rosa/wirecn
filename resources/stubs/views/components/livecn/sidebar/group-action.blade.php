<button
    type="button"
    data-slot="sidebar-group-action"
    data-sidebar="group-action"
    {{ $attributes->class(cn(
        'absolute top-3.5 right-3 flex aspect-square w-5 items-center justify-center rounded-md p-0 text-sidebar-foreground ring-sidebar-ring outline-hidden transition-transform',
        'group-data-[collapsible=icon]:hidden',
        'after:absolute after:-inset-2 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 md:after:hidden',
        '[&_svg]:size-4 [&_svg]:shrink-0',
    )) }}
>
    {{ $slot }}
</button>
