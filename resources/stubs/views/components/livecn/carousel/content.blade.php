<div x-ref="viewport" class="overflow-hidden" data-slot="carousel-content">
    <div
        {{ $attributes->class(cn(
            'flex group-data-[orientation=vertical]/carousel:-mt-4 group-data-[orientation=vertical]/carousel:flex-col group-data-[orientation=horizontal]/carousel:-ml-4',
        )) }}
    >
        {{ $slot }}
    </div>
</div>
