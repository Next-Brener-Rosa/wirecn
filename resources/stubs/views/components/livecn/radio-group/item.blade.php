@props([
    'value' => '',
    'disabled' => false,
    'invalid' => false,
])

@php
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $invalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $userClass = $attributes->get('class');
@endphp

<div class="{{ cn('relative inline-flex aspect-square size-4 shrink-0', $userClass) }}">
    <input
        type="radio"
        value="{{ $value }}"
        @disabled($disabled)
        x-init="$el.name = $el.closest('[data-slot=radio-group]').dataset.radioGroupName"
        x-bind:checked="selected === @js((string) $value)"
        x-on:change="selected = $event.target.value"
        {{ $attributes->except('class')->merge([
            'aria-invalid' => $invalid ? 'true' : null,
        ]) }}
        class="{{ cn(
            'peer absolute inset-0 z-10 size-4 cursor-pointer appearance-none opacity-0 disabled:cursor-not-allowed',
        ) }}"
    />
    <span
        data-slot="radio-group-item"
        class="{{ cn(
            'pointer-events-none relative flex aspect-square size-4 shrink-0 rounded-full border border-input outline-none',
            'after:absolute after:-inset-x-3 after:-inset-y-2',
            'peer-focus-visible:border-ring peer-focus-visible:ring-3 peer-focus-visible:ring-ring/50',
            'peer-disabled:cursor-not-allowed peer-disabled:opacity-50',
            'peer-aria-invalid:border-destructive peer-aria-invalid:ring-3 peer-aria-invalid:ring-destructive/20',
            'peer-aria-invalid:peer-checked:border-primary',
            'dark:bg-input/30 dark:peer-aria-invalid:border-destructive/50 dark:peer-aria-invalid:ring-destructive/40',
            'peer-checked:border-primary peer-checked:bg-primary peer-checked:text-primary-foreground dark:peer-checked:bg-primary',
            'peer-checked:[&_[data-slot=radio-group-indicator]]:opacity-100',
        ) }}"
        aria-hidden="true"
    >
        <span
            data-slot="radio-group-indicator"
            class="{{ cn(
                'flex size-4 items-center justify-center opacity-0 transition-opacity',
            ) }}"
        >
            <span class="absolute top-1/2 left-1/2 size-2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-primary-foreground"></span>
        </span>
    </span>
</div>
