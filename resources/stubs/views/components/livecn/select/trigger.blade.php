@props([
    'size' => 'default',
])

@php
    $size = in_array($size, ['sm', 'default', 'lg'], true) ? $size : 'default';
@endphp

<button
    type="button"
    x-ref="reference"
    data-slot="select-trigger"
    data-size="{{ $size }}"
    x-bind:id="triggerId"
    x-bind:aria-expanded="panelOpen.toString()"
    x-bind:aria-controls="listboxId"
    aria-haspopup="listbox"
    x-bind:disabled="disabled"
    x-bind:aria-invalid="invalid ? 'true' : null"
    x-bind:class="invalid ? 'border-destructive focus-visible:border-destructive focus-visible:ring-destructive/20 dark:border-destructive/50 dark:focus-visible:ring-destructive/40' : ''"
    x-on:click.stop="toggle()"
    {{ $attributes->class(cn(
        'flex w-fit max-w-full select-none items-center justify-between gap-1.5 rounded-lg border border-input bg-transparent py-2 pr-2 pl-2.5 text-left text-sm whitespace-nowrap shadow-sm ring-offset-background transition-colors outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-input dark:bg-input/30 dark:hover:bg-input/50',
        'data-[size=default]:h-8 data-[size=sm]:h-7 data-[size=lg]:h-11 data-[size=sm]:rounded-md data-[size=lg]:rounded-md',
        '*:data-[slot=select-value]:line-clamp-1 *:data-[slot=select-value]:flex *:data-[slot=select-value]:items-center *:data-[slot=select-value]:gap-1.5',
        '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4',
    )) }}
>
    {{ $slot }}
    <span class="pointer-events-none text-muted-foreground" data-slot="select-icon" aria-hidden="true">
        <x-livecn.phosphor-icon name="chevron-down" class="size-3" />
    </span>
</button>
