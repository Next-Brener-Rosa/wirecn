@props([
    'align' => 'center',
    'alignOffset' => 0,
    'side' => 'bottom',
    'sideOffset' => 4,
])

@php
    $alignOffset = (int) $alignOffset;
    $sideOffset = (int) $sideOffset;
@endphp

<div
    x-data="uiPopover({ align: @js($align), alignOffset: @js($alignOffset), side: @js($side), sideOffset: @js($sideOffset) })"
    data-slot="popover"
    x-on:keydown.escape.window="close()"
    {{ $attributes->class(cn('relative inline-block text-left')) }}
>
    {{ $slot }}
</div>
