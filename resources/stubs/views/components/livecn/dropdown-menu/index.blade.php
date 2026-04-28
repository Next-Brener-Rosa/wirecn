@props([
    'align' => 'start',
    'alignOffset' => 0,
    'side' => 'bottom',
    'sideOffset' => 4,
    'focusFirstOnOpen' => true,
])

@php
    $alignOffset = (int) $alignOffset;
    $sideOffset = (int) $sideOffset;
    $focusFirstOnOpen = filter_var($focusFirstOnOpen, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    x-data="uiDropdownMenu({ align: @js($align), alignOffset: @js($alignOffset), side: @js($side), sideOffset: @js($sideOffset), focusFirstOnOpen: @js($focusFirstOnOpen) })"
    data-slot="dropdown-menu"
    x-on:keydown.escape.window="close()"
    {{ $attributes->class(cn('relative inline-block text-left')) }}
>
    {{ $slot }}
</div>
