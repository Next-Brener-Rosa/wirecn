@props([
    'orientation' => 'horizontal',
])

@php
    $orientation = in_array($orientation, ['horizontal', 'vertical'], true) ? $orientation : 'horizontal';
    $isVertical = $orientation === 'vertical';
@endphp

<div
    role="separator"
    aria-orientation="{{ $isVertical ? 'vertical' : 'horizontal' }}"
    data-slot="separator"
    data-orientation="{{ $orientation }}"
    @if ($isVertical)
        data-vertical
    @else
        data-horizontal
    @endif
    {{ $attributes->class(cn(
        'shrink-0 bg-border',
        'data-horizontal:h-px data-horizontal:w-full',
        'data-vertical:w-px data-vertical:self-stretch',
    )) }}
></div>
