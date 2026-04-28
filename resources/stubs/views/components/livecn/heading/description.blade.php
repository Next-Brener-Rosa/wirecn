@props([
    'size' => 'default',
])

@php
    $size = in_array($size, ['default', 'sm', 'lg'], true) ? $size : 'default';

    $sizeClass = match ($size) {
        'sm' => 'text-xs',
        'lg' => 'text-base',
        default => 'text-sm',
    };
@endphp

<p data-slot="heading-description" {{ $attributes->class(cn('text-muted-foreground', $sizeClass)) }}>
    {{ $slot }}
</p>
