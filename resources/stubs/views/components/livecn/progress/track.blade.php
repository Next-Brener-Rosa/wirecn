<div
    data-slot="progress-track"
    role="presentation"
    {{ $attributes->class(cn(
        'relative flex h-1 w-full basis-full items-center overflow-x-hidden rounded-full bg-muted',
    )) }}
>
    {{ $slot }}
</div>
