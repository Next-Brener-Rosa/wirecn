@props([
    'value' => '',
])

<div
    role="radiogroup"
    data-slot="context-menu-radio-group"
    x-data="{ selected: @js((string) $value) }"
    {{ $attributes }}
>
    {{ $slot }}
</div>
