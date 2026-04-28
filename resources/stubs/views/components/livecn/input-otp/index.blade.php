@props([
    'length' => 6,
    'name' => null,
    'initialValue' => '',
    'disabled' => false,
    'invalid' => false,
    'containerClass' => null,
])

@php
    $length = max(1, (int) $length);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $invalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);

    $keys = array_keys($attributes->getAttributes());
    $wireKeys = array_values(array_filter($keys, fn ($k) => str_starts_with((string) $k, 'wire:')));
    $wireAttrs = $attributes->only($wireKeys);
    $rootAttrs = $attributes->except($wireKeys);
@endphp

<div
    x-data="uiInputOtp({ length: @js($length), initialValue: @js((string) $initialValue), disabled: @js($disabled) })"
    data-slot="input-otp"
    {{ $rootAttrs->class(cn('relative inline-block disabled:cursor-not-allowed')) }}
>
    @if ($name)
        <input
            type="hidden"
            name="{{ $name }}"
            x-bind:value="value"
            @if ($disabled)
                disabled
            @endif
        />
    @endif
    <div
        class="{{ cn(
            'cn-input-otp relative inline-block has-disabled:opacity-50',
            'has-[input[aria-invalid=true]]:rounded-lg has-[input[aria-invalid=true]]:ring-3 has-[input[aria-invalid=true]]:ring-destructive/20',
            'dark:has-[input[aria-invalid=true]]:ring-destructive/40',
        ) }}"
    >
        <div
            class="{{ cn(
                'pointer-events-none inline-flex flex-row items-center',
                $containerClass,
            ) }}"
        >
            {{ $slot }}
        </div>
        <input
            type="text"
            inputmode="numeric"
            pattern="[0-9]*"
            autocomplete="one-time-code"
            spellcheck="false"
            x-ref="otpInput"
            :value="value"
            x-on:focus="focused = true"
            x-on:blur="focused = false"
            x-on:input="setValueFromEvent($event)"
            x-bind:disabled="disabled"
            maxlength="{{ $length }}"
            @if ($invalid)
                aria-invalid="true"
            @endif
            {{ $wireAttrs->class(cn(
                'absolute inset-0 z-20 h-full w-full cursor-text border-0 bg-transparent p-0 opacity-0 outline-none',
            )) }}
        />
    </div>
</div>
