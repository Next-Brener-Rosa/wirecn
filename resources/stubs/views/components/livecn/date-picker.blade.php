@props([
    'invalid' => false,
])

@php
    $inputId = $attributes->get('id') ?? 'date-'.Illuminate\Support\Str::random(8);
    $base = 'flex h-10 w-full appearance-none rounded-md border border-input bg-background px-3 py-2 pe-10 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50';
    $state = $invalid ? 'border-destructive focus-visible:ring-destructive' : '';
@endphp

<div class="{{ cn('relative w-full max-w-xs') }}">
    <x-livecn.label for="{{ $inputId }}" class="{{ cn('sr-only') }}">{{ __('Data') }}</x-livecn.label>
    <input
        type="date"
        id="{{ $inputId }}"
        {{ $attributes->except('id')->class(cn($base, $state))->merge($invalid ? ['aria-invalid' => 'true'] : []) }}
    >
    <span class="pointer-events-none absolute end-3 top-1/2 -translate-y-1/2 text-muted-foreground" aria-hidden="true">
        <x-livecn.phosphor-icon name="calendar" class="size-4" />
    </span>
</div>
