<button
    type="button"
    data-sidebar="rail"
    data-slot="sidebar-rail"
    aria-label="{{ __('Alternar barra lateral') }}"
    tabindex="-1"
    title="{{ __('Alternar barra lateral') }}"
    x-on:click="toggleSidebar()"
    {{ $attributes->class(cn(
        'absolute inset-y-0 z-20 hidden w-4 transition-all ease-linear sm:flex',
        'group-data-[side=left]:-right-4 group-data-[side=right]:-left-4',
        'after:absolute after:inset-y-0 after:left-1/2 after:w-0.5 after:-translate-x-1/2 hover:after:bg-sidebar-border',
        'group-data-[collapsible=offcanvas]:translate-x-0 hover:group-data-[collapsible=offcanvas]:bg-sidebar',
        '[[data-side=left][data-collapsible=offcanvas]_&]:-right-2 [[data-side=right][data-collapsible=offcanvas]_&]:-left-2',
    )) }}
></button>
