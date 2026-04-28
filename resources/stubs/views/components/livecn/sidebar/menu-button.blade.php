@props([
    'variant' => 'default',
    'size' => 'default',
    'isActive' => false,
    'tooltip' => null,
    'href' => null,
])

@php
    $isActive = filter_var($isActive, FILTER_VALIDATE_BOOLEAN);

    $variant = in_array($variant, ['default', 'outline'], true) ? $variant : 'default';
    $size = in_array($size, ['default', 'sm', 'lg'], true) ? $size : 'default';

    $variantClass = match ($variant) {
        'outline' => 'bg-background shadow-[0_0_0_1px_hsl(var(--sidebar-border))] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground hover:shadow-[0_0_0_1px_hsl(var(--sidebar-accent))]',
        default => 'hover:bg-sidebar-accent hover:text-sidebar-accent-foreground',
    };

    $sizeClass = match ($size) {
        'sm' => 'h-7 text-xs',
        'lg' => 'h-12 text-sm group-data-[collapsible=icon]:!p-0',
        default => 'h-8 text-sm',
    };

    $class = cn(
        'peer/menu-button group/menu-button flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm ring-sidebar-ring outline-hidden transition-[width,height,padding]',
        'group-has-[[data-sidebar=menu-action]]/menu-item:pr-8',
        'group-data-[collapsible=icon]:!size-8 group-data-[collapsible=icon]:!p-2',
        'focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground',
        'disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50',
        'data-open:hover:bg-sidebar-accent data-open:hover:text-sidebar-accent-foreground',
        'data-active:bg-sidebar-accent data-active:font-medium data-active:text-sidebar-accent-foreground',
        '[&_svg]:size-4 [&_svg]:shrink-0 [&>span:last-child]:truncate',
        $variantClass,
        $sizeClass,
    );
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        data-slot="sidebar-menu-button"
        data-sidebar="menu-button"
        data-size="{{ $size }}"
        @if ($isActive) data-active @endif
        @if ($tooltip)
            x-bind:title="(open || isMobile) ? '' : @js($tooltip)"
        @endif
        {{ $attributes->class($class) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="button"
        data-slot="sidebar-menu-button"
        data-sidebar="menu-button"
        data-size="{{ $size }}"
        @if ($isActive) data-active @endif
        @if ($tooltip)
            x-bind:title="(open || isMobile) ? '' : @js($tooltip)"
        @endif
        {{ $attributes->class($class) }}
    >
        {{ $slot }}
    </button>
@endif
