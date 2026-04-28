@props([
    'name' => 'radio',
    'value' => '',
    'withoutAlpine' => false,
])

@php
    $withoutAlpine = filter_var($withoutAlpine, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    role="radiogroup"
    data-slot="radio-group"
    data-radio-group-name="{{ $name }}"
    @unless ($withoutAlpine)
        x-data="{ selected: @js((string) $value) }"
    @endunless
    {{ $attributes->class(cn(
        $withoutAlpine ? '' : 'grid w-full gap-2',
    )) }}
>
    {{ $slot }}
</div>
