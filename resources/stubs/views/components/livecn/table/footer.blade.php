<tfoot
    data-slot="table-footer"
    {{ $attributes->class(cn(
        'border-t bg-muted/50 font-medium [&>tr]:last:border-b-0',
    )) }}
>
    {{ $slot }}
</tfoot>
