<p
    data-slot="dialog-description"
    {{ $attributes->class(cn(
        'text-xs text-muted-foreground *:[a]:underline *:[a]:underline-offset-3 *:[a]:hover:text-foreground',
    )) }}
>
    {{ $slot }}
</p>
