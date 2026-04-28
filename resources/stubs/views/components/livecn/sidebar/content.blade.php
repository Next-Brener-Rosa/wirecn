<div
    data-slot="sidebar-content"
    data-sidebar="content"
    {{ $attributes->class(cn(
        'no-scrollbar flex min-h-0 flex-1 flex-col gap-0 overflow-auto group-data-[collapsible=icon]:overflow-hidden',
    )) }}
>
    {{ $slot }}
</div>
