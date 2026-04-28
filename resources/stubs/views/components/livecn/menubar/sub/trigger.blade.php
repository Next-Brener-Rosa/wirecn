@props([
    'inset' => false,
])

@php
    $inset = filter_var($inset, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    x-ref="subTrigger"
    role="menuitem"
    aria-haspopup="menu"
    data-slot="menubar-sub-trigger"
    x-bind:aria-expanded="open ? 'true' : 'false'"
    x-on:mouseenter="scheduleOpen()"
    x-on:mouseleave="scheduleClose()"
    @if ($inset)
        data-inset
    @endif
    {{ $attributes->class(cn(
        'flex cursor-default items-center gap-1.5 rounded-md px-1.5 py-1 text-sm outline-hidden select-none',
        'focus:bg-accent focus:text-accent-foreground',
        'data-inset:pl-7',
        'data-popup-open:bg-accent data-popup-open:text-accent-foreground',
        'data-open:bg-accent data-open:text-accent-foreground',
        '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4',
    )) }}
    x-bind:data-open="open ? '' : null"
>
    {{ $slot }}
    <x-livecn.phosphor-icon name="chevron-right" class="ml-auto [[dir=rtl]_&]:scale-x-[-1]" />
</div>
