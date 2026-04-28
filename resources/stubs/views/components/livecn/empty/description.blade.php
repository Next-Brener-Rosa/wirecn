<p
    data-slot="empty-description"
    {{ $attributes->class(cn(
        'text-sm/relaxed text-muted-foreground [&>a]:underline [&>a]:underline-offset-4 [&>a:hover]:text-primary',
    )) }}
>
    {{ $slot }}
</p>
