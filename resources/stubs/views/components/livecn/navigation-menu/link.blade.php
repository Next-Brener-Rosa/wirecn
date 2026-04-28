@props([
    'active' => false,
    'href' => '#',
])

@php
    $active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
@endphp

<a
    data-slot="navigation-menu-link"
    href="{{ $href }}"
    @if ($active)
        data-active
    @endif
    {{ $attributes->class(cn(
        'flex items-center gap-2 rounded-lg p-2 text-sm transition-all outline-none',
        'hover:bg-muted focus:bg-muted focus-visible:ring-3 focus-visible:ring-ring/50 focus-visible:outline-1',
        'in-data-[slot=navigation-menu-content]:rounded-md',
        'data-active:bg-muted/50 data-active:hover:bg-muted data-active:focus:bg-muted',
        '[&_svg:not([class*=\'size-\'])]:size-4',
    )) }}
>
    {{ $slot }}
</a>
