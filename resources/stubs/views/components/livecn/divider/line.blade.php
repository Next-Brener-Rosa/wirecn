@props([
    'variant' => 'default',
    'orientation' => 'horizontal',
    'side' => null,
])

@aware([
    'variant' => 'default',
    'orientation' => 'horizontal',
])

@php
    $variant = in_array($variant, ['default', 'glow', 'dashed', 'circuit'], true) ? $variant : 'default';
    $orientation = $orientation === 'vertical' ? 'vertical' : 'horizontal';
    $isHorizontal = $orientation === 'horizontal';
    $userClass = $attributes->get('class');

    $lineHorizontal = match ($variant) {
        'default' => 'relative flex-1 h-px bg-primary/20',
        'glow' => 'relative flex-1 h-px bg-primary/30 shadow-[0_0_4px_var(--primary)]',
        'dashed' => 'relative flex-1 border-t border-dashed border-primary/30',
        'circuit' => 'relative flex-1 h-px bg-primary/20',
    };

    $lineVertical = match ($variant) {
        'default' => 'relative inline-flex self-stretch w-px bg-primary/20',
        'glow' => 'relative inline-flex self-stretch w-px bg-primary/30 shadow-[0_0_4px_var(--primary)]',
        'dashed' => 'relative inline-flex self-stretch w-px border-l border-dashed border-primary/30',
        'circuit' => 'relative inline-flex self-stretch w-px bg-primary/20',
    };
@endphp

@if ($isHorizontal)
    <div
        data-slot="divider-line"
        @if (filled($side))
            data-side="{{ $side }}"
        @endif
        class="{{ cn($lineHorizontal, $userClass) }}"
        {{ $attributes->except('class') }}
    >
        @if ($variant === 'circuit' && $side === 'left')
            <div class="absolute top-1/2 left-0 h-1.5 w-1.5 -translate-y-1/2 rounded-full bg-primary/40"></div>
            <div
                class="absolute top-1/2 left-1/2 h-1 w-1 -translate-x-1/2 -translate-y-1/2 rounded-full bg-primary/80"
            ></div>
        @endif
        @if ($variant === 'circuit' && $side === 'right')
            <div class="absolute top-1/2 right-0 h-1.5 w-1.5 -translate-y-1/2 rounded-full bg-primary/40"></div>
        @endif
    </div>
@else
    <div
        data-slot="divider-line"
        class="{{ cn($lineVertical, $userClass) }}"
        {{ $attributes->except('class') }}
    >
        @if ($variant === 'circuit')
            <div
                class="absolute top-0 left-1/2 h-1.5 w-1.5 -translate-x-1/2 rounded-full bg-primary/60"
            ></div>
        @endif
    </div>
@endif
