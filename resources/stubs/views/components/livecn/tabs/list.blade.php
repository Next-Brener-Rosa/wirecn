@props([
    'variant' => 'default',
])

@php
    $variant = in_array($variant, ['default', 'line'], true) ? $variant : 'default';

    $variantClasses = match ($variant) {
        'line' => 'gap-1 bg-transparent',
        default => 'bg-muted',
    };
@endphp

<div
    role="tablist"
    data-slot="tabs-list"
    data-variant="{{ $variant }}"
    {{ $attributes->class(cn(
        'group/tabs-list inline-flex w-fit items-center justify-center rounded-lg p-[3px] text-muted-foreground',
        'group-data-horizontal/tabs:h-8 group-data-vertical/tabs:h-fit group-data-vertical/tabs:flex-col',
        'data-[variant=line]:rounded-none',
        $variantClasses,
    )) }}
>
    {{ $slot }}
</div>
