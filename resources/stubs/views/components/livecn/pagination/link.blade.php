@props([
    'href' => '#',
    'isActive' => false,
    'size' => 'icon',
    'disabled' => false,
])

@php
    $isActive = filter_var($isActive, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $size = in_array($size, ['default', 'xs', 'sm', 'lg', 'icon', 'icon-xs', 'icon-sm', 'icon-lg'], true)
        ? $size
        : 'icon';

    $attributes = $attributes->merge(['data-slot' => 'pagination-link']);

    if ($isActive) {
        $attributes = $attributes->merge([
            'aria-current' => 'page',
            'data-active' => true,
        ]);
    }

    if ($disabled) {
        $attributes = $attributes->merge(['disabled' => true])
            ->class(cn('pointer-events-none opacity-50'));
    }
@endphp

<x-livecn.button
    :href="$disabled ? null : $href"
    :variant="$isActive ? 'outline' : 'ghost'"
    :size="$size"
    {{ $attributes }}
>
    {{ $slot }}
</x-livecn.button>
