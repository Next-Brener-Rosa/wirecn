<ol
    data-slot="breadcrumb-list"
    {{ $attributes->class(cn(
        'flex flex-wrap items-center gap-1.5 text-sm wrap-break-word text-muted-foreground',
    )) }}
>
    {{ $slot }}
</ol>
