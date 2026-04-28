@props([
    'inset' => false,
    'checked' => false,
    'disabled' => false,
])

@php
    $inset = filter_var($inset, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp

<button
    type="button"
    role="menuitemcheckbox"
    data-slot="menubar-checkbox-item"
    x-data="{ checked: @js((bool) $checked) }"
    x-bind:aria-checked="checked ? 'true' : 'false'"
    x-on:click="checked = !checked; $dispatch('menubar-checkbox-change', { checked })"
    @if ($inset)
        data-inset
    @endif
    @if ($disabled)
        disabled
        data-disabled
        aria-disabled="true"
    @endif
    {{ $attributes->class(cn(
        'relative flex w-full cursor-default items-center gap-1.5 rounded-md py-1 pr-1.5 pl-7 text-left text-sm outline-hidden select-none',
        'focus:bg-accent focus:text-accent-foreground focus:**:text-accent-foreground',
        'data-inset:pl-7',
        'data-disabled:pointer-events-none data-disabled:opacity-50',
        '[&_svg]:pointer-events-none [&_svg]:shrink-0',
    )) }}
>
    <span
        class="{{ cn('pointer-events-none absolute left-1.5 flex size-4 items-center justify-center [&_svg:not([class*=\'size-\'])]:size-4') }}"
        data-slot="menubar-checkbox-item-indicator"
    >
        <x-livecn.phosphor-icon name="check" class="size-4" x-show="checked" x-cloak />
    </span>
    {{ $slot }}
</button>
