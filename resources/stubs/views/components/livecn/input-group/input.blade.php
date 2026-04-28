@props([
    'invalid' => false,
])

@php
    $invalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
@endphp

<input
    data-slot="input-group-control"
    @if ($invalid)
        aria-invalid="true"
    @endif
    {{ $attributes->class(cn(
        'flex-1 min-h-0 h-8 w-full rounded-none border-0 bg-transparent px-2.5 py-1 text-base outline-none shadow-none',
        'file:inline-flex file:h-6 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground',
        'placeholder:text-muted-foreground',
        'focus-visible:ring-0',
        'disabled:pointer-events-none disabled:cursor-not-allowed disabled:bg-transparent disabled:opacity-50',
        'aria-invalid:ring-0',
        'md:text-sm',
        'dark:bg-transparent dark:disabled:bg-transparent',
    )) }}
/>
