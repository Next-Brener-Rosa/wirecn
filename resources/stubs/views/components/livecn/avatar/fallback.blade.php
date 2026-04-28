<span
    data-slot="avatar-fallback"
    {{ $attributes->class(cn(
        'flex size-full items-center justify-center rounded-full bg-muted text-sm text-muted-foreground',
        'group-data-[size=sm]/avatar:text-xs',
    )) }}
>
    {{ $slot }}
</span>
