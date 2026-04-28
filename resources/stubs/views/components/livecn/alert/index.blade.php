@props([
    'variant' => 'default',
])

@php
    $variant = in_array($variant, ['default', 'destructive'], true) ? $variant : 'default';
    $variantClasses = match ($variant) {
        'destructive' => 'bg-card text-destructive *:data-[slot=alert-description]:text-destructive/90 [&_svg]:text-current',
        default => 'bg-card text-card-foreground',
    };
@endphp

<div
    data-slot="alert"
    role="alert"
    {{ $attributes->class(cn(
        'relative grid w-full grid-cols-[0_1fr] items-start gap-y-0.5 rounded-lg border border-border px-4 py-3 text-sm has-[[data-phosphor-icon]]:grid-cols-[1rem_1fr] has-[[data-phosphor-icon]]:gap-x-3 [&_svg]:size-4 [&_svg]:translate-y-0.5 [&_svg]:text-current',
        $variantClasses,
    )) }}
>
    {{ $slot }}
</div>
