@props([
    'defaultOpen' => true,
])

@php
    $defaultOpen = filter_var($defaultOpen, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    x-data="uiSidebar({ defaultOpen: @js($defaultOpen) })"
    data-slot="sidebar-wrapper"
    style="--sidebar-width: 16rem; --sidebar-width-icon: 3rem;"
    {{ $attributes->class(cn(
        'group/sidebar-wrapper flex min-h-svh w-full has-[[data-variant=inset]]:bg-sidebar',
    )) }}
>
    {{ $slot }}
</div>
