<span
    data-slot="breadcrumb-ellipsis"
    role="presentation"
    aria-hidden="true"
    {{ $attributes->class(cn(
        'flex size-5 items-center justify-center [&_svg]:size-4',
    )) }}
>
    <x-livecn.phosphor-icon name="more-horizontal" />
    <span class="sr-only">Mais</span>
</span>
