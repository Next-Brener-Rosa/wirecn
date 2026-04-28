@props([
    'showIcon' => false,
])

@php
    $showIcon = filter_var($showIcon, FILTER_VALIDATE_BOOLEAN);
    $skeletonWidth = (string) random_int(50, 90);
@endphp

<div
    data-slot="sidebar-menu-skeleton"
    data-sidebar="menu-skeleton"
    {{ $attributes->class(cn('flex h-8 items-center gap-2 rounded-md px-2')) }}
>
    @if ($showIcon)
        <x-livecn.skeleton class="size-4 rounded-md" data-sidebar="menu-skeleton-icon" />
    @endif
    <x-livecn.skeleton
        class="h-4 flex-1 max-w-[var(--skeleton-width)]"
        data-sidebar="menu-skeleton-text"
        style="--skeleton-width: {{ $skeletonWidth }}%;"
    />
</div>
