@props([
    'inset' => false,
])

@php
    $inset = filter_var($inset, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    data-slot="context-menu-label"
    @if ($inset)
        data-inset
    @endif
    role="presentation"
    {{ $attributes->class(cn(
        'px-1.5 py-1 text-xs font-medium text-muted-foreground data-inset:pl-7',
    )) }}
>
    {{ $slot }}
</div>
