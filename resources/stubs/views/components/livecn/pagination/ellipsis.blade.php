<span
    aria-hidden="true"
    data-slot="pagination-ellipsis"
    {{ $attributes->class(cn(
        'flex size-8 items-center justify-center [&_svg:not([class*=\'size-\'])]:size-4',
    )) }}
>
    <x-livecn.phosphor-icon name="more-horizontal" />
    <span class="sr-only">More pages</span>
</span>
