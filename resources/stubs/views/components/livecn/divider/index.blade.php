@props([
    'label' => null,
    'variant' => 'default',
    'orientation' => 'horizontal',
])

@php
    $variant = in_array($variant, ['default', 'glow', 'dashed', 'circuit'], true) ? $variant : 'default';
    $orientation = $orientation === 'vertical' ? 'vertical' : 'horizontal';
    $isHorizontal = $orientation === 'horizontal';
    $slotEmpty = $slot->isEmpty();
    $userClass = $attributes->get('class');
@endphp

@if ($slotEmpty && ! $isHorizontal)
    <div
        data-slot="divider"
        role="presentation"
        class="{{ cn('relative inline-flex self-stretch', $userClass) }}"
        {{ $attributes->except('class') }}
    >
        <x-livecn.divider.line :variant="$variant" :orientation="$orientation" />
    </div>
@elseif ($slotEmpty && $isHorizontal)
    <div
        data-slot="divider"
        role="presentation"
        class="{{ cn('relative flex w-full min-w-0 items-center', $userClass) }}"
        {{ $attributes->except('class') }}
    >
        <x-livecn.divider.line side="left" :variant="$variant" :orientation="$orientation" />
        @if (filled($label))
            <x-livecn.divider.label :variant="$variant" :orientation="$orientation">{{ $label }}</x-livecn.divider.label>
        @endif
        <x-livecn.divider.line side="right" :variant="$variant" :orientation="$orientation" />
    </div>
@else
    <div
        data-slot="divider"
        role="presentation"
        class="{{ cn(
            $isHorizontal ? 'relative flex w-full min-w-0 items-center' : 'relative inline-flex self-stretch',
            $userClass,
        ) }}"
        {{ $attributes->except('class') }}
    >
        {{ $slot }}
    </div>
@endif
