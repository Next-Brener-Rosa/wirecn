<div
    data-slot="menubar"
    {{ $attributes->class(cn(
        'flex h-8 items-center gap-0.5 rounded-lg border p-[3px]',
    )) }}
>
    {{ $slot }}
</div>
