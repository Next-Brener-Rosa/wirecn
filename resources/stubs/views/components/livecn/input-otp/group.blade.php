@props([
    'invalid' => false,
])

@php
    $invalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    data-slot="input-otp-group"
    role="presentation"
    @if ($invalid)
        aria-invalid="true"
    @endif
    {{ $attributes->class(cn(
        'flex items-center rounded-lg',
        'aria-invalid:border-destructive aria-invalid:ring-3 aria-invalid:ring-destructive/20',
        'dark:aria-invalid:ring-destructive/40',
    )) }}
>
    {{ $slot }}
</div>
