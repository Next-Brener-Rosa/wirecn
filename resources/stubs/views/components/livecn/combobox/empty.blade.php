<div
    data-slot="combobox-empty"
    x-show="open && filtered.length === 0"
    x-cloak
    {{ $attributes->class(cn(
        'flex w-full justify-center py-2 text-center text-sm text-muted-foreground',
    )) }}
>
    {{ $slot }}
</div>
