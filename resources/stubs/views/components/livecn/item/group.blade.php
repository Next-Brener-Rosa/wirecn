<div
    role="list"
    data-slot="item-group"
    {{ $attributes->class(cn(
        'group/item-group flex w-full flex-col gap-4 has-data-[size=sm]:gap-2.5 has-data-[size=xs]:gap-2',
    )) }}
>
    {{ $slot }}
</div>
