@props([
    'delay' => 0,
])

<div
    data-slot="tooltip-provider"
    data-tooltip-delay="{{ (int) $delay }}"
    {{ $attributes }}
>
    {{ $slot }}
</div>
