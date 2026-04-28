<td
    data-slot="table-cell"
    {{ $attributes->class(cn(
        'p-2 align-middle whitespace-nowrap [&:has([role=checkbox])]:pr-0',
    )) }}
>
    {{ $slot }}
</td>
