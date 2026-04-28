@props([
    'variant' => 'outline',
    'size' => 'default',
])

<x-livecn.button
    type="button"
    data-slot="alert-dialog-cancel"
    variant="{{ $variant }}"
    size="{{ $size }}"
    x-on:click="close()"
    {{ $attributes }}
>
    {{ $slot }}
</x-livecn.button>
