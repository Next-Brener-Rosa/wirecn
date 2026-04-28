@props([
    'variant' => 'default',
])

@php
    $variant = in_array($variant, ['default', 'icon'], true) ? $variant : 'default';
@endphp

@php
    $variantClass = match ($variant) {
        'icon' => 'flex size-8 shrink-0 items-center justify-center rounded-lg bg-muted text-foreground [&_svg:not([class*=\'size-\'])]:size-4',
        default => 'bg-transparent',
    };
@endphp

<div
    data-slot="empty-icon"
    data-variant="{{ $variant }}"
    {{ $attributes->class(cn(
        'mb-2 flex shrink-0 items-center justify-center [&_svg]:pointer-events-none [&_svg]:shrink-0',
        $variantClass,
    )) }}
>
    {{ $slot }}
</div>
