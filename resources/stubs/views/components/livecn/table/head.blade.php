<th
    data-slot="table-head"
    {{ $attributes->class(cn(
        'h-10 px-2 text-left align-middle font-medium whitespace-nowrap text-foreground [&:has([role=checkbox])]:pr-0',
    )) }}
>
    {{ $slot }}
</th>
