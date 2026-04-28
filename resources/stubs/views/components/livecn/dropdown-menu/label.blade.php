@props([
    'inset' => false,
])

@php
    $inset = filter_var($inset, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    data-slot="dropdown-menu-label"
    role="presentation"
    @if ($inset)
        data-inset
    @endif
    {{ $attributes->class(cn(
        'px-1.5 py-1 text-xs font-medium text-muted-foreground data-inset:pl-7',
    )) }}
>
    {{ $slot }}
</div>
