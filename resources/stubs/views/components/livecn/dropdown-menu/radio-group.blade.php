@props([
    'value' => '',
])

<div
    role="radiogroup"
    data-slot="dropdown-menu-radio-group"
    x-data="{ selected: @js((string) $value) }"
    {{ $attributes }}
>
    {{ $slot }}
</div>
