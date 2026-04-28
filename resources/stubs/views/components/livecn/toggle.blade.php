@props([
    'variant' => 'default',
    'size' => 'default',
    'pressed' => false,
    'disabled' => false,
    'invalid' => false,
    'type' => 'button',
])

@php
    $variant = in_array($variant, ['default', 'outline'], true) ? $variant : 'default';
    $size = in_array($size, ['default', 'sm', 'lg'], true) ? $size : 'default';
    $pressed = filter_var($pressed, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $invalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);

    $type = in_array($type, ['button', 'submit'], true) ? $type : 'button';

    $base = 'group/toggle inline-flex items-center justify-center gap-1 rounded-md text-sm font-medium whitespace-nowrap transition-all outline-none hover:bg-muted hover:text-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:pointer-events-none disabled:opacity-50 aria-invalid:border-destructive aria-invalid:ring-destructive/20 aria-pressed:bg-muted data-[state=on]:bg-muted dark:aria-invalid:ring-destructive/40 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4';

    $variantClass = match ($variant) {
        'outline' => 'border border-input bg-transparent hover:bg-muted',
        default => 'bg-transparent',
    };

    $sizeClass = match ($size) {
        'sm' => 'h-7 min-w-7 rounded-[min(var(--radius-md),12px)] px-2.5 text-[0.8rem] has-data-[icon=inline-end]:pr-1.5 has-data-[icon=inline-start]:pl-1.5 [&_svg:not([class*=\'size-\'])]:size-3.5',
        'lg' => 'h-9 min-w-9 px-2.5 has-data-[icon=inline-end]:pr-2 has-data-[icon=inline-start]:pl-2',
        default => 'h-8 min-w-8 px-2.5 has-data-[icon=inline-end]:pr-2 has-data-[icon=inline-start]:pl-2',
    };
@endphp

<button
    type="{{ $type }}"
    data-slot="toggle"
    x-data="{ pressed: @js($pressed) }"
    x-on:click="if (! $el.disabled) { pressed = ! pressed }"
    x-bind:aria-pressed="pressed ? 'true' : 'false'"
    x-bind:data-state="pressed ? 'on' : 'off'"
    @disabled($disabled)
    {{ $attributes->merge($invalid ? ['aria-invalid' => 'true'] : [])->class(cn($base, $variantClass, $sizeClass)) }}
>{{ $slot }}</button>
