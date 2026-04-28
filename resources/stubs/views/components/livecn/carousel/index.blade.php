@props([
    'orientation' => 'horizontal',
    'opts' => [],
])

@php
    $orientation = in_array($orientation, ['horizontal', 'vertical'], true)
        ? $orientation
        : 'horizontal';

    $carouselConfig = [
        'orientation' => $orientation,
        'opts' => is_array($opts) ? $opts : [],
    ];
@endphp

<div
    x-data="uiCarousel(@js($carouselConfig))"
    x-on:keydown.capture="onKeydown($event)"
    role="region"
    aria-roledescription="carousel"
    tabindex="0"
    data-slot="carousel"
    data-orientation="{{ $orientation }}"
    {{ $attributes->class(cn('group/carousel relative outline-none')) }}
>
    {{ $slot }}
</div>
