@props([
    'invalid' => false,
])

@php
    $invalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $userClass = $attributes->get('class');

    $visual = cn(
        'pointer-events-none relative flex size-4 shrink-0 items-center justify-center rounded-[4px] border border-input bg-background text-primary-foreground transition-colors outline-none',
        'after:absolute after:-inset-x-3 after:-inset-y-2',
        'group-has-disabled/field:opacity-50',
        'peer-focus-visible:border-ring peer-focus-visible:ring-3 peer-focus-visible:ring-ring/50',
        'peer-disabled:cursor-not-allowed peer-disabled:opacity-50',
        'peer-aria-invalid:border-destructive peer-aria-invalid:ring-3 peer-aria-invalid:ring-destructive/20',
        'peer-aria-invalid:peer-checked:border-primary',
        'dark:bg-input/30 dark:peer-aria-invalid:border-destructive/50 dark:peer-aria-invalid:ring-destructive/40',
        'peer-checked:border-primary peer-checked:bg-primary peer-checked:text-primary-foreground dark:peer-checked:bg-primary',
        'peer-checked:[&_[data-slot=checkbox-indicator]]:opacity-100',
    );

    $inputClass = cn(
        'peer absolute inset-0 z-10 size-4 cursor-pointer appearance-none opacity-0 disabled:cursor-not-allowed',
    );
@endphp

<div class="{{ cn('relative inline-flex size-4 shrink-0', $userClass) }}">
    <input
        type="checkbox"
        {{ $attributes->except('class')->merge([
            'aria-invalid' => $invalid ? 'true' : null,
        ]) }}
        class="{{ $inputClass }}"
    />
    <span data-slot="checkbox" class="{{ $visual }}" aria-hidden="true">
        <span
            data-slot="checkbox-indicator"
            class="{{ cn(
                'grid place-content-center text-current opacity-0 transition-none [&_svg]:size-3.5',
            ) }}"
        >
            <x-livecn.phosphor-icon name="check" />
        </span>
    </span>
</div>
