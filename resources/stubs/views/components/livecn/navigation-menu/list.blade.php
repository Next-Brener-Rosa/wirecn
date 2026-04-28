<ul
    data-slot="navigation-menu-list"
    role="menubar"
    aria-orientation="horizontal"
    {{ $attributes->class(cn(
        'group flex flex-1 list-none items-center justify-center gap-0',
    )) }}
>
    {{ $slot }}
</ul>
