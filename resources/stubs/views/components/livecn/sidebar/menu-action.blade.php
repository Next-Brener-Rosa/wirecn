@props([
    'showOnHover' => false,
])

@php
    $showOnHover = filter_var($showOnHover, FILTER_VALIDATE_BOOLEAN);
@endphp

<button
    type="button"
    data-sidebar="menu-action"
    data-slot="sidebar-menu-action"
    {{ $attributes->class(cn(
        'absolute top-1.5 right-1 z-10 flex aspect-square w-5 items-center justify-center rounded-md p-0 text-sidebar-foreground ring-sidebar-ring outline-hidden transition-transform',
        'group-data-[collapsible=icon]:hidden',
        'peer-hover/menu-button:text-sidebar-accent-foreground',
        'peer-data-[size=default]/menu-button:top-1.5 peer-data-[size=lg]/menu-button:top-2.5 peer-data-[size=sm]/menu-button:top-1',
        'after:absolute after:-inset-2 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 md:after:hidden',
        '[&_svg]:size-4 [&_svg]:shrink-0',
        $showOnHover
            ? 'group-focus-within/menu-item:opacity-100 group-hover/menu-item:opacity-100 peer-data-active/menu-button:text-sidebar-accent-foreground aria-expanded:opacity-100 md:opacity-0'
            : '',
    )) }}
>
    {{ $slot }}
</button>
