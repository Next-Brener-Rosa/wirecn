<div
    data-slot="alert-dialog-media"
    {{ $attributes->class(cn(
        'mb-2 inline-flex size-10 items-center justify-center rounded-md bg-muted',
        'sm:group-data-[size=default]/alert-dialog-content:row-span-2 [&_svg:not([class*=\'size-\'])]:size-6',
    )) }}
>
    {{ $slot }}
</div>
