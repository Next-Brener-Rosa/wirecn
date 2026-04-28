@props([
    'value' => '',
    'disabled' => false,
    'invalid' => false,
])

@aware([
    'variant' => 'default',
    'size' => 'default',
    'spacing' => 0,
    'orientation' => 'horizontal',
])

@php
    $variant = in_array($variant, ['default', 'outline'], true) ? $variant : 'default';
    $size = in_array($size, ['default', 'sm', 'lg'], true) ? $size : 'default';
    $spacing = (int) $spacing;
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $invalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);

    $valueJson = json_encode($value, JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

    $base = 'group/toggle inline-flex shrink-0 items-center justify-center gap-1 rounded-lg text-sm font-medium whitespace-nowrap transition-all outline-none hover:bg-muted hover:text-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:pointer-events-none disabled:opacity-50 aria-invalid:border-destructive aria-invalid:ring-destructive/20 aria-pressed:bg-muted data-[state=on]:bg-muted dark:aria-invalid:ring-destructive/40 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4';

    $variantClass = match ($variant) {
        'outline' => 'border border-input bg-transparent hover:bg-muted',
        default => 'bg-transparent',
    };

    $sizeClass = match ($size) {
        'sm' => 'h-7 min-w-7 rounded-[min(var(--radius-md),12px)] px-2.5 text-[0.8rem] has-data-[icon=inline-end]:pr-1.5 has-data-[icon=inline-start]:pl-1.5 [&_svg:not([class*=\'size-\'])]:size-3.5',
        'lg' => 'h-9 min-w-9 px-2.5 has-data-[icon=inline-end]:pr-2 has-data-[icon=inline-start]:pl-2',
        default => 'h-8 min-w-8 px-2.5 has-data-[icon=inline-end]:pr-2 has-data-[icon=inline-start]:pl-2',
    };

    $groupItemClass = 'shrink-0 group-data-[spacing=0]/toggle-group:rounded-none group-data-[spacing=0]/toggle-group:px-2 focus:z-10 focus-visible:z-10 group-data-[spacing=0]/toggle-group:has-data-[icon=inline-end]:pr-1.5 group-data-[spacing=0]/toggle-group:has-data-[icon=inline-start]:pl-1.5 group-data-horizontal/toggle-group:data-[spacing=0]:first:rounded-l-lg group-data-vertical/toggle-group:data-[spacing=0]:first:rounded-t-lg group-data-horizontal/toggle-group:data-[spacing=0]:last:rounded-r-lg group-data-vertical/toggle-group:data-[spacing=0]:last:rounded-b-lg group-data-horizontal/toggle-group:data-[spacing=0]:data-[variant=outline]:border-l-0 group-data-vertical/toggle-group:data-[spacing=0]:data-[variant=outline]:border-t-0 group-data-horizontal/toggle-group:data-[spacing=0]:data-[variant=outline]:first:border-l group-data-vertical/toggle-group:data-[spacing=0]:data-[variant=outline]:first:border-t';
@endphp

<button
    type="button"
    data-slot="toggle-group-item"
    data-variant="{{ $variant }}"
    data-size="{{ $size }}"
    data-spacing="{{ $spacing }}"
    x-on:click='if (! $el.disabled) { toggleValue({!! $valueJson !!}) }'
    x-bind:aria-pressed='isOn({!! $valueJson !!}) ? "true" : "false"'
    x-bind:data-state='isOn({!! $valueJson !!}) ? "on" : "off"'
    @disabled($disabled)
    {{ $attributes->merge($invalid ? ['aria-invalid' => 'true'] : [])->class(cn($base, $variantClass, $sizeClass, $groupItemClass)) }}
>{{ $slot }}</button>
