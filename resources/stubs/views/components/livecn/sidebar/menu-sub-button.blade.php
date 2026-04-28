@props([
    'size' => 'md',
    'isActive' => false,
    'href' => null,
])

@php
    $isActive = filter_var($isActive, FILTER_VALIDATE_BOOLEAN);
    $size = in_array($size, ['sm', 'md'], true) ? $size : 'md';

    $shared = cn(
        'flex h-7 min-w-0 -translate-x-px items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground ring-sidebar-ring outline-hidden',
        'group-data-[collapsible=icon]:hidden',
        'hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2',
        'active:bg-sidebar-accent active:text-sidebar-accent-foreground',
        'disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50',
        'data-[size=md]:text-sm data-[size=sm]:text-xs',
        'data-active:bg-sidebar-accent data-active:text-sidebar-accent-foreground',
        '[&>span:last-child]:truncate [&_svg]:size-4 [&_svg]:shrink-0 [&_svg]:text-sidebar-accent-foreground',
    );
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        data-slot="sidebar-menu-sub-button"
        data-sidebar="menu-sub-button"
        data-size="{{ $size }}"
        @if ($isActive) data-active @endif
        {{ $attributes->class($shared) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="button"
        data-slot="sidebar-menu-sub-button"
        data-sidebar="menu-sub-button"
        data-size="{{ $size }}"
        @if ($isActive) data-active @endif
        {{ $attributes->class($shared) }}
    >
        {{ $slot }}
    </button>
@endif
