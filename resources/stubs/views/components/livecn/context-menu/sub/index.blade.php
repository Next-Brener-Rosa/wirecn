<div
    x-data="uiContextMenuSub()"
    data-slot="context-menu-sub"
    {{ $attributes->class(cn('relative')) }}
>
    {{ $slot }}
</div>
