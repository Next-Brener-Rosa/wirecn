@props([
    'align' => 'start',
    'alignOffset' => -4,
    'side' => 'bottom',
    'sideOffset' => 8,
])

@php
    $alignOffset = (int) $alignOffset;
    $sideOffset = (int) $sideOffset;
@endphp

<div
    x-data="uiDropdownMenu({ align: @js($align), alignOffset: @js($alignOffset), side: @js($side), sideOffset: @js($sideOffset) })"
    data-slot="menubar-menu"
    x-on:keydown.escape.window="close()"
    {{ $attributes->class(cn('relative inline-block text-left')) }}
>
    {{ $slot }}
</div>
