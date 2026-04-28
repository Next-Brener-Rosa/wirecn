@props([
    'value' => '',
])

<div
    role="radiogroup"
    data-slot="menubar-radio-group"
    x-data="{ selected: @js((string) $value) }"
    {{ $attributes }}
>
    {{ $slot }}
</div>
