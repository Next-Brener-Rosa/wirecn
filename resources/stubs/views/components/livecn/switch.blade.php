@props([
    'checked' => false,
    'name' => null,
    'value' => '1',
    'size' => 'default',
    'disabled' => false,
    'invalid' => false,
])

@php
    $size = in_array($size, ['sm', 'default'], true) ? $size : 'default';
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $invalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $id = $attributes->get('id') ?? 'switch-'.str()->random(8);
@endphp

<div x-data="{ on: @js((bool) $checked) }" class="inline-flex items-center gap-2">
    @if ($name)
        <input type="hidden" name="{{ $name }}" x-bind:value="on ? '{{ $value }}' : ''">
    @endif
    <button
        type="button"
        role="switch"
        id="{{ $id }}"
        data-slot="switch"
        data-size="{{ $size }}"
        x-bind:aria-checked="on ? 'true' : 'false'"
        x-bind:data-checked="on ? '' : null"
        x-bind:data-unchecked="on ? null : ''"
        x-on:click="if (! $el.disabled) { on = ! on }"
        @disabled($disabled)
        @if ($disabled)
            data-disabled
        @endif
        @if ($invalid)
            aria-invalid="true"
        @endif
        {{ $attributes->except(['id'])->class(cn(
            'peer group/switch relative inline-flex shrink-0 items-center rounded-full border border-transparent transition-all outline-none after:absolute after:-inset-x-3 after:-inset-y-2',
            'focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50',
            'aria-invalid:border-destructive aria-invalid:ring-3 aria-invalid:ring-destructive/20',
            'dark:aria-invalid:border-destructive/50 dark:aria-invalid:ring-destructive/40',
            'data-[size=default]:h-[18.4px] data-[size=default]:w-[32px] data-[size=sm]:h-[14px] data-[size=sm]:w-[24px]',
            'data-checked:bg-primary data-unchecked:bg-input dark:data-unchecked:bg-input/80',
            'data-disabled:cursor-not-allowed data-disabled:opacity-50',
        )) }}
    >
        <span
            data-slot="switch-thumb"
            aria-hidden="true"
            x-bind:data-checked="on ? '' : null"
            x-bind:data-unchecked="on ? null : ''"
            class="{{ cn(
                'pointer-events-none block rounded-full bg-background ring-0 transition-transform',
                'group-data-[size=default]/switch:size-4 group-data-[size=sm]/switch:size-3',
                'group-data-[size=default]/switch:data-checked:translate-x-[calc(100%-2px)] group-data-[size=sm]/switch:data-checked:translate-x-[calc(100%-2px)]',
                'dark:data-checked:bg-primary-foreground',
                'group-data-[size=default]/switch:data-unchecked:translate-x-0 group-data-[size=sm]/switch:data-unchecked:translate-x-0',
                'dark:data-unchecked:bg-foreground',
            ) }}"
        ></span>
    </button>
</div>
