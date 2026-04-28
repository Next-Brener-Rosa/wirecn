@props([
    'name',
    'variant' => null,
    'weight' => null,
])

<x-livecn.phosphor-icon
    :name="$name"
    :variant="$variant"
    :weight="$weight ?? 'regular'"
    {{ $attributes }}
/>
