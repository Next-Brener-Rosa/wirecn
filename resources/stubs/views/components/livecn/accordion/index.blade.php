@props([
    'defaultValue' => null,
])

<div
    data-slot="accordion"
    x-data="{ open: @js($defaultValue) }"
    {{ $attributes->class(cn('flex w-full flex-col')) }}
>
    {{ $slot }}
</div>
