@props([
    'type' => 'button',
    'variant' => 'ghost',
    'size' => 'xs',
])

@php
    $type = in_array($type, ['button', 'submit', 'reset'], true) ? $type : 'button';
    $size = in_array($size, ['xs', 'sm', 'icon-xs', 'icon-sm'], true) ? $size : 'xs';

    $buttonSize = match ($size) {
        'sm' => 'sm',
        'icon-xs' => 'icon-xs',
        'icon-sm' => 'icon-sm',
        default => 'xs',
    };

    $extraClass = match ($size) {
        'sm' => '',
        'icon-xs' => 'rounded-[calc(var(--radius)-3px)] p-0 has-[[data-phosphor-icon]]:p-0',
        'icon-sm' => 'p-0 has-[[data-phosphor-icon]]:p-0',
        default => 'rounded-[calc(var(--radius)-3px)] [&_svg:not([class*=\'size-\'])]:size-3.5',
    };
@endphp

<x-livecn.button
    type="{{ $type }}"
    variant="{{ $variant }}"
    size="{{ $buttonSize }}"
    data-size="{{ $size }}"
    {{ $attributes->class(cn('shadow-none', $extraClass)) }}
>
    {{ $slot }}
</x-livecn.button>
