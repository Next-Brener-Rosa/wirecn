@props([
    'src' => null,
    'alt' => '',
])

<img
    data-slot="avatar-image"
    src="{{ $src }}"
    alt="{{ $alt }}"
    {{ $attributes->class(cn(
        'aspect-square size-full rounded-full object-cover',
    )) }}
/>
