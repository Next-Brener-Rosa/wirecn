@props([
    'value' => '',
    'inset' => false,
    'disabled' => false,
])

@php
    $inset = filter_var($inset, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp

<button
    type="button"
    role="menuitemradio"
    data-slot="context-menu-radio-item"
    data-context-menu-autoclose
    x-on:click="selected = @js((string) $value)"
    x-bind:aria-checked="selected === @js((string) $value) ? 'true' : 'false'"
    @if ($inset)
        data-inset
    @endif
    @if ($disabled)
        disabled
        data-disabled
        aria-disabled="true"
    @endif
    {{ $attributes->class(cn(
        'relative flex w-full cursor-default items-center gap-1.5 rounded-md py-1 pr-8 pl-1.5 text-left text-sm outline-none select-none',
        'focus:bg-accent focus:text-accent-foreground',
        'data-inset:pl-7',
        'data-disabled:pointer-events-none data-disabled:opacity-50',
        '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4',
    )) }}
>
    <span class="{{ cn('pointer-events-none absolute right-2 flex size-4 items-center justify-center') }}">
        <x-livecn.phosphor-icon name="check" class="size-4" x-show="selected === @js((string) $value)" x-cloak />
    </span>
    {{ $slot }}
</button>
