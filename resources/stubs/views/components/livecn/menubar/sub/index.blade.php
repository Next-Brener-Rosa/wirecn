@props([
    'align' => 'start',
    'alignOffset' => -3,
    'side' => 'right',
    'sideOffset' => 0,
])

@php
    $alignOffset = (int) $alignOffset;
    $sideOffset = (int) $sideOffset;
@endphp

<div
    x-data="uiDropdownMenuSub({ align: @js($align), alignOffset: @js($alignOffset), side: @js($side), sideOffset: @js($sideOffset) })"
    data-slot="menubar-sub"
    {{ $attributes->class(cn('relative')) }}
>
    {{ $slot }}
</div>
