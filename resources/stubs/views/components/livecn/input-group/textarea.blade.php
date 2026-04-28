@props([
    'invalid' => false,
    'rows' => 3,
])

@php
    $invalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
@endphp

<textarea
    data-slot="input-group-control"
    rows="{{ $rows }}"
    @if ($invalid)
        aria-invalid="true"
    @endif
    {{ $attributes->class(cn(
        'flex-1 min-h-0 w-full resize-none rounded-none border-0 bg-transparent px-2.5 py-2 text-base outline-none shadow-none',
        'placeholder:text-muted-foreground',
        'focus-visible:ring-0',
        'disabled:cursor-not-allowed disabled:bg-transparent disabled:opacity-50',
        'aria-invalid:ring-0',
        'md:text-sm',
        'dark:bg-transparent dark:disabled:bg-transparent',
    )) }}
>{{ $slot }}</textarea>
