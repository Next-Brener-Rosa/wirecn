<div
    data-slot="item-footer"
    {{ $attributes->class(cn(
        'flex basis-full items-center justify-between gap-2',
    )) }}
>
    {{ $slot }}
</div>
