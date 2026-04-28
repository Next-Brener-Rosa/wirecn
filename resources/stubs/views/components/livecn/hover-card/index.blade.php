@props([
    'align' => 'center',
    'alignOffset' => 4,
    'side' => 'bottom',
    'sideOffset' => 4,
])

@php
    $alignOffset = (int) $alignOffset;
    $sideOffset = (int) $sideOffset;
@endphp

<div
    x-data="uiHoverCard({ align: @js($align), alignOffset: @js($alignOffset), side: @js($side), sideOffset: @js($sideOffset) })"
    data-slot="hover-card"
    {{ $attributes->class(cn('relative inline-block')) }}
>
    {{ $slot }}
</div>
