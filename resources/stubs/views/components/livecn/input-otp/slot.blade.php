@props([
    'index' => 0,
])

@php
    $index = (int) $index;
@endphp

<div
    data-slot="input-otp-slot"
    x-bind:data-active="isActive({{ $index }}) ? 'true' : null"
    {{ $attributes->class(cn(
        'relative flex size-8 items-center justify-center border-y border-r border-input text-sm transition-all outline-none',
        'first:rounded-l-lg first:border-l last:rounded-r-lg',
        'aria-invalid:border-destructive',
        'data-[active=true]:z-10 data-[active=true]:border-ring data-[active=true]:ring-3 data-[active=true]:ring-ring/50',
        'data-[active=true]:aria-invalid:border-destructive data-[active=true]:aria-invalid:ring-destructive/20',
        'dark:bg-input/30 dark:data-[active=true]:aria-invalid:ring-destructive/40',
    )) }}
>
    <span x-text="slotChar({{ $index }})" class="tabular-nums"></span>
    <div
        class="{{ cn('pointer-events-none absolute inset-0 flex items-center justify-center') }}"
        x-show="hasFakeCaret({{ $index }})"
        x-cloak
    >
        <div class="{{ cn('h-4 w-px animate-caret-blink bg-foreground duration-1000') }}"></div>
    </div>
</div>
