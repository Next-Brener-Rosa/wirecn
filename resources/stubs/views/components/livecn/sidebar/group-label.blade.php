<div
    data-slot="sidebar-group-label"
    data-sidebar="group-label"
    {{ $attributes->class(cn(
        'flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-medium text-sidebar-foreground/70 ring-sidebar-ring outline-hidden transition-[margin,opacity] duration-200 ease-linear',
        'group-data-[collapsible=icon]:-mt-8 group-data-[collapsible=icon]:opacity-0',
        'focus-visible:ring-2 [&_svg]:size-4 [&_svg]:shrink-0',
    )) }}
>
    {{ $slot }}
</div>
