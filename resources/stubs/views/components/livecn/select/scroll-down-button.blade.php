<button
    type="button"
    tabindex="-1"
    data-slot="select-scroll-down-button"
    x-show="canScrollDown"
    x-cloak
    x-on:click.prevent="scrollListBy(48)"
    x-on:mouseenter="startScrollHover(1)"
    x-on:mouseleave="stopScrollHover()"
    {{ $attributes->class(cn(
        'z-10 flex w-full shrink-0 cursor-default items-center justify-center bg-popover py-1 text-muted-foreground hover:bg-accent/50 hover:text-foreground dark:hover:bg-accent/20',
        '[&_svg:not([class*=\'size-\'])]:size-4',
    )) }}
    aria-hidden="true"
>
    <x-livecn.phosphor-icon name="chevron-down" />
</button>
