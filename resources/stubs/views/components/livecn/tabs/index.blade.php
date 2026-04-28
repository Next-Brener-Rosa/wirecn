@props([
    'default' => null,
    'orientation' => 'horizontal',
])

@php
    $defaultTab = $default ?? ($attributes->get('data-default') ?? null);
    $orientation = $orientation === 'vertical' ? 'vertical' : 'horizontal';
@endphp

<div
    x-data="uiTabs({ defaultValue: @js($defaultTab), orientation: @js($orientation) })"
    data-slot="tabs"
    data-orientation="{{ $orientation }}"
    @if ($orientation === 'horizontal')
        data-horizontal
    @else
        data-vertical
    @endif
    {{ $attributes->class(cn(
        'group/tabs flex gap-2 data-horizontal:flex-col',
    )) }}
>
    {{ $slot }}
</div>
