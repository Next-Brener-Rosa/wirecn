@props([
    'variant' => 'default',
])

@php
    $variant = in_array($variant, ['default', 'icon', 'image'], true) ? $variant : 'default';

    $base = 'flex shrink-0 items-center justify-center gap-2 group-has-data-[slot=item-description]/item:translate-y-0.5 group-has-data-[slot=item-description]/item:self-start [&_svg]:pointer-events-none';

    $variants = [
        'default' => 'bg-transparent',
        'icon' => '[&_svg:not([class*=\'size-\'])]:size-4',
        'image' => 'size-10 overflow-hidden rounded-sm group-data-[size=sm]/item:size-8 group-data-[size=xs]/item:size-6 [&_img]:size-full [&_img]:object-cover',
    ];
@endphp

<div
    data-slot="item-media"
    data-variant="{{ $variant }}"
    {{ $attributes->class(cn($base, $variants[$variant])) }}
>
    {{ $slot }}
</div>
