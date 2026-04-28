@props([
    'value' => '',
    'disabled' => false,
])

@php
    $valueJson = json_encode((string) $value, JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
@endphp

<h3 class="flex">
    <button
        type="button"
        data-slot="accordion-trigger"
        x-on:click="@js(! $disabled) && (open = open === {{ $valueJson }} ? null : {{ $valueJson }})"
        x-bind:aria-expanded="(open === {{ $valueJson }}).toString()"
        @if ($disabled)
            aria-disabled="true"
        @endif
        @disabled($disabled)
        {{ $attributes->class(cn(
            'group/accordion-trigger relative flex flex-1 items-start justify-between gap-2 rounded-lg border border-transparent py-2.5 pr-1 text-left text-sm font-medium transition-all outline-none hover:underline focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50',
            '*:data-[slot=accordion-trigger-icon]:ml-auto *:data-[slot=accordion-trigger-icon]:size-4 *:data-[slot=accordion-trigger-icon]:shrink-0 *:data-[slot=accordion-trigger-icon]:text-muted-foreground',
        )) }}
    >
        {{ $slot }}
        <x-livecn.phosphor-icon name="chevron-down"
            data-slot="accordion-trigger-icon"
            class="{{ cn('pointer-events-none group-aria-expanded/accordion-trigger:hidden') }}"
            aria-hidden="true"
        />
        <x-livecn.phosphor-icon name="chevron-up"
            data-slot="accordion-trigger-icon"
            class="{{ cn('pointer-events-none hidden group-aria-expanded/accordion-trigger:inline') }}"
            aria-hidden="true"
        />
    </button>
</h3>
