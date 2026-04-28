<div
    role="group"
    aria-roledescription="slide"
    data-slot="carousel-item"
    {{ $attributes->class(cn(
        'min-w-0 shrink-0 grow-0 basis-full group-data-[orientation=horizontal]/carousel:pl-4 group-data-[orientation=vertical]/carousel:pt-4',
    )) }}
>
    {{ $slot }}
</div>
