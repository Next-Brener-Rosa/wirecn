@props([
    'variant' => 'ghost',
    'size' => 'default',
])

<x-livecn.button
    type="button"
    variant="{{ $variant }}"
    size="{{ $size }}"
    data-slot="dialog-close"
    x-on:click="close()"
    {{ $attributes }}
>
    {{ $slot }}
</x-livecn.button>
