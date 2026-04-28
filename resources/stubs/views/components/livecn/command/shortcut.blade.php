<span
    data-slot="command-shortcut"
    {{ $attributes->class(cn(
        'ml-auto text-xs tracking-widest text-muted-foreground group-data-[selected=true]/command-item:text-foreground',
    )) }}
>{{ $slot }}</span>
