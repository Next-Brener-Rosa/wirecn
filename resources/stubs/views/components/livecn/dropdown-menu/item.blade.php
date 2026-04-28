@props([
    'href' => null,
    'inset' => false,
    'variant' => 'default',
    'disabled' => false,
    'onclick' => null,
    'onClick' => null,
    'type' => 'button',
])

@php
    $inset = filter_var($inset, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $variant = in_array($variant, ['default', 'destructive'], true) ? $variant : 'default';
    $type = in_array($type, ['button', 'submit', 'reset'], true) ? $type : 'button';

    $clickHandler = $onClick ?? $onclick;

    if (filled($clickHandler)) {
        $attributes = $attributes->merge(['onclick' => $clickHandler]);
    }
@endphp

@php
    $itemClass = cn(
        'group/dropdown-menu-item relative flex w-full cursor-default select-none items-center gap-1.5 rounded-md px-1.5 py-1 text-sm outline-none',
        'hover:bg-accent hover:text-accent-foreground',
        'focus-visible:bg-accent focus-visible:text-accent-foreground',
        'data-inset:pl-7',
        'data-[variant=destructive]:text-destructive data-[variant=destructive]:hover:bg-destructive/10 data-[variant=destructive]:hover:text-destructive data-[variant=destructive]:focus-visible:bg-destructive/10 data-[variant=destructive]:focus-visible:text-destructive',
        'dark:data-[variant=destructive]:hover:bg-destructive/20 dark:data-[variant=destructive]:focus-visible:bg-destructive/20',
        'data-disabled:pointer-events-none data-disabled:opacity-50',
        '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4',
        'data-[variant=destructive]:*:[svg]:text-destructive',
    );
@endphp

@if ($href && ! $disabled)
    <a
        href="{{ $href }}"
        role="menuitem"
        data-slot="dropdown-menu-item"
        @if ($inset)
            data-inset
        @endif
        data-variant="{{ $variant }}"
        {{ $attributes->class(cn($itemClass)) }}
    >
        {{ $slot }}
    </a>
@else
    @if ($href && $disabled)
        <span
            role="menuitem"
            aria-disabled="true"
            data-slot="dropdown-menu-item"
            data-disabled
            data-variant="{{ $variant }}"
            @if ($inset)
                data-inset
            @endif
            {{ $attributes->class(cn($itemClass)) }}
        >
            {{ $slot }}
        </span>
    @else
        <button
            type="{{ $type }}"
            role="menuitem"
            data-slot="dropdown-menu-item"
            @if ($inset)
                data-inset
            @endif
            data-variant="{{ $variant }}"
            @if ($disabled)
                disabled
                data-disabled
                aria-disabled="true"
            @endif
            {{ $attributes->class(cn($itemClass, 'text-left')) }}
        >
            {{ $slot }}
        </button>
    @endif
@endif
