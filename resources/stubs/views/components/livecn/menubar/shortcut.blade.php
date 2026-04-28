<span
    data-slot="menubar-shortcut"
    {{ $attributes->class(cn(
        'ml-auto text-xs tracking-widest text-muted-foreground group-focus/menubar-item:text-accent-foreground',
    )) }}
>{{ $slot }}</span>
