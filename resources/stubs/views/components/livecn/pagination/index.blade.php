<nav
    role="navigation"
    aria-label="pagination"
    data-slot="pagination"
    {{ $attributes->class(cn(
        'mx-auto flex w-full justify-center',
    )) }}
>
    {{ $slot }}
</nav>
