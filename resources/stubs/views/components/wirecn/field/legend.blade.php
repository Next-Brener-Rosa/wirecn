@props([
    'variant' => 'legend',
])

@php
    $variant = in_array($variant, ['legend', 'label'], true) ? $variant : 'legend';
@endphp

<legend
    data-slot="field-legend"
    data-variant="{{ $variant }}"
    {{ $attributes->class(cn(
        'mb-1.5 font-medium data-[variant=label]:text-sm data-[variant=legend]:text-base',
    )) }}
>
    {{ $slot }}
</legend>
