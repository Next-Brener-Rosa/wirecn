@props([
    'side' => 'top',
    'align' => 'center',
    'sideOffset' => 4,
    'alignOffset' => 0,
    'delay' => null,
])

@php
    $sideOffset = (int) $sideOffset;
    $alignOffset = (int) $alignOffset;
@endphp

<div
    x-data="uiTooltip({ side: @js($side), align: @js($align), sideOffset: @js($sideOffset), alignOffset: @js($alignOffset), delay: @js($delay) })"
    data-slot="tooltip"
    {{ $attributes->class(cn('relative inline-flex')) }}
>
    @if (isset($trigger) && isset($content))
        <x-livecn.tooltip.trigger>{{ $trigger }}</x-livecn.tooltip.trigger>
        <x-livecn.tooltip.content>{{ $content }}</x-livecn.tooltip.content>
    @else
        {{ $slot }}
    @endif
</div>
