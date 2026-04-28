@props([
    'name',
    'weight' => 'regular',
    'variant' => null,
    'label' => null,
])

@php
    $phosphorWeight = \Illuminate\Support\Str::lower((string) ($weight ?? 'regular'));
    if ($phosphorWeight === 'solid') {
        $phosphorWeight = 'fill';
    }

    $iconClasses = cn(\Livecn\Laravel\Support\UiIcon::sizeForVariant($variant), $attributes->get('class'));
@endphp
<span
    data-phosphor-icon
    data-name="{{ \Illuminate\Support\Str::lower((string) $name) }}"
    data-weight="{{ $phosphorWeight }}"
    @if ($label !== null) data-aria-label="{{ $label }}" @endif
    {{ $attributes->except(['class', 'variant', 'weight'])->merge(['class' => 'contents']) }}
>
    <span
        wire:ignore
        data-phosphor-react-root
        class="{{ cn('inline-flex shrink-0', $iconClasses) }}"
    ></span>
</span>
