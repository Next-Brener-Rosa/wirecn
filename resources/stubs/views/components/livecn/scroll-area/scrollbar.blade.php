@props([
    'orientation' => 'vertical',
])

@php
    $orientation = in_array($orientation, ['vertical', 'horizontal'], true) ? $orientation : 'vertical';
@endphp

<div
    data-slot="scroll-area-scrollbar"
    data-orientation="{{ $orientation }}"
    @if ($orientation === 'horizontal')
        data-horizontal
    @else
        data-vertical
    @endif
    {{ $attributes->class(cn(
        'flex touch-none p-px transition-colors select-none',
        'data-horizontal:h-2.5 data-horizontal:flex-col data-horizontal:border-t data-horizontal:border-t-transparent',
        'data-vertical:h-full data-vertical:w-2.5 data-vertical:border-l data-vertical:border-l-transparent',
    )) }}
>
    <div
        data-slot="scroll-area-thumb"
        class="{{ cn(
            'relative flex-1 rounded-full bg-border',
        ) }}"
    ></div>
</div>
