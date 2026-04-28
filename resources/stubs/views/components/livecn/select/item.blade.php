@props([
    'value' => '',
    'disabled' => false,
])

@php
    $optionId = 'ui-select-opt-'.Illuminate\Support\Str::slug((string) $value).'-'.Illuminate\Support\Str::random(6);
@endphp

<div
    id="{{ $optionId }}"
    data-slot="select-item"
    role="option"
    aria-selected="false"
    data-ui-select-option
    data-value="{{ $value }}"
    @if ($disabled)
        data-disabled
    @endif
    x-on:mouseenter="setActiveFromEl($event.currentTarget)"
    x-on:click.prevent="selectFromEl($event.currentTarget)"
    {{ $attributes->class(cn(
        'relative flex w-full cursor-default select-none items-center gap-1.5 rounded-md py-1 pr-8 pl-1.5 text-sm outline-none focus:bg-accent focus:text-accent-foreground data-[disabled=true]:pointer-events-none data-[disabled=true]:opacity-50',
        '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4',
    )) }}
>
    <span data-slot="select-item-text" data-ui-select-option-text class="{{ cn('flex min-w-0 flex-1 items-center gap-2 whitespace-nowrap') }}">
        {{ $slot }}
    </span>
    <span
        class="{{ cn('pointer-events-none absolute right-2 flex size-4 items-center justify-center') }}"
        x-show="isOptionSelected(@js((string) $value))"
        x-cloak
        data-slot="select-item-indicator"
        aria-hidden="true"
    >
        <x-livecn.phosphor-icon name="check" class="size-4" />
    </span>
</div>
