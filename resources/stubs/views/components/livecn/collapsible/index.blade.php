@props([
    'open' => false,
])

<div
    x-data="{ open: @js((bool) $open) }"
    data-slot="collapsible"
    {{ $attributes->class(cn('w-full')) }}
>
    {{ $slot }}
</div>
