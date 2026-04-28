@props([
    'variant' => 'outline',
    'size' => 'icon-sm',
])

<x-livecn.button
    type="button"
    data-slot="carousel-previous"
    variant="{{ $variant }}"
    size="{{ $size }}"
    x-on:click="scrollPrev()"
    x-bind:disabled="!canScrollPrev"
    {{ $attributes->class(cn(
        'absolute touch-manipulation rounded-full',
        'group-data-[orientation=horizontal]/carousel:top-1/2 group-data-[orientation=horizontal]/carousel:-left-12 group-data-[orientation=horizontal]/carousel:-translate-y-1/2',
        'group-data-[orientation=vertical]/carousel:-top-12 group-data-[orientation=vertical]/carousel:left-1/2 group-data-[orientation=vertical]/carousel:-translate-x-1/2 group-data-[orientation=vertical]/carousel:rotate-90',
    )) }}
>
    <x-livecn.phosphor-icon name="chevron-left" class="[[dir=rtl]_&]:rotate-180" />
    <span class="sr-only">{{ __('Slide anterior') }}</span>
</x-livecn.button>
