<div
    data-slot="avatar-group-count"
    {{ $attributes->class(cn(
        'relative flex size-8 shrink-0 items-center justify-center rounded-full bg-muted text-sm text-muted-foreground ring-2 ring-background',
        'group-has-data-[size=lg]/avatar-group:size-10 group-has-data-[size=sm]/avatar-group:size-6',
        '[&_svg]:size-4 group-has-data-[size=lg]/avatar-group:[&_svg]:size-5 group-has-data-[size=sm]/avatar-group:[&_svg]:size-3',
    )) }}
>
    {{ $slot }}
</div>
