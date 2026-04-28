@props([
    'hoverable' => true,
])

@php
    $hoverable = filter_var($hoverable, FILTER_VALIDATE_BOOLEAN);
@endphp

<button
    type="button"
    data-slot="combobox-trigger"
    x-bind:disabled="disabled"
    x-on:click.prevent="toggle()"
    {{ $attributes->class(cn(
        "[&_svg:not([class*='size-'])]:size-4 inline-flex shrink-0 items-center justify-center rounded-md text-muted-foreground data-pressed:bg-transparent",
        $hoverable ? 'transition-colors hover:bg-muted hover:text-foreground' : '',
    )) }}
>
    {{ $slot }}
    <x-livecn.phosphor-icon name="chevron-down" class="pointer-events-none size-3 text-muted-foreground" />
</button>
