@props([
    'value' => '',
    'disabled' => false,
])

<x-livecn.select.item :value="$value" :disabled="$disabled" {{ $attributes }}>
    {{ $slot }}
</x-livecn.select.item>
