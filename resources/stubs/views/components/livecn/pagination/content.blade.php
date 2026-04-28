<ul
    data-slot="pagination-content"
    {{ $attributes->class(cn(
        'flex items-center gap-0.5',
    )) }}
>
    {{ $slot }}
</ul>
