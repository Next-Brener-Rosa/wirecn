@props([
    'size' => 'default',
])

@php
    $size = in_array($size, ['default', 'sm', 'lg'], true) ? $size : 'default';

    $sizeClass = match ($size) {
        'sm' => 'text-lg',
        'lg' => 'text-3xl',
        default => 'text-2xl',
    };
@endphp

<h2
    data-slot="heading-title"
    {{ $attributes->class(cn(
        'leading-none font-bold text-foreground',
        $sizeClass,
    )) }}
>{{ $slot }}</h2>
