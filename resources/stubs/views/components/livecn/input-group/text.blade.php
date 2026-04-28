<span
    {{ $attributes->class(cn(
        'flex items-center gap-2 text-sm text-muted-foreground [&_svg]:pointer-events-none [&_svg:not([class*=\'size-\'])]:size-4',
    )) }}
>
    {{ $slot }}
</span>
