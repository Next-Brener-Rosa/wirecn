<div
    data-slot="alert-dialog-footer"
    {{ $attributes->class(cn(
        '-mx-4 -mb-4 flex flex-col-reverse gap-2 rounded-b-xl border-t border-border bg-muted/50 p-4',
        'group-data-[size=sm]/alert-dialog-content:grid group-data-[size=sm]/alert-dialog-content:grid-cols-2',
        'sm:flex-row sm:justify-end',
    )) }}
>
    {{ $slot }}
</div>
