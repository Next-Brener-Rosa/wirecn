@props([
    'variant' => 'default',
    'orientation' => 'horizontal',
])

@aware([
    'variant' => 'default',
    'orientation' => 'horizontal',
])

@php
    $userClass = $attributes->get('class');
@endphp

<span
    data-slot="divider-label"
    class="{{ cn(
        'mx-3 shrink-0 tabular-nums text-[0.625rem] tracking-widest text-foreground/30 uppercase',
        $userClass,
    ) }}"
    {{ $attributes->except('class') }}
>{{ $slot }}</span>
