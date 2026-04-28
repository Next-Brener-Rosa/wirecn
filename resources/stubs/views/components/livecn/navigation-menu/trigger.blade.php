@php
    $triggerStyle = cn(
        'group/navigation-menu-trigger group inline-flex h-9 w-max items-center justify-center gap-2 rounded-lg px-2.5 py-1.5 text-sm font-medium transition-all outline-none cursor-pointer',
        'hover:bg-muted focus:bg-muted focus-visible:ring-3 focus-visible:ring-ring/50 focus-visible:outline-1',
        'disabled:pointer-events-none disabled:opacity-50',
        'data-popup-open:bg-muted/50 data-popup-open:hover:bg-muted data-open:bg-muted/50 data-open:hover:bg-muted data-open:focus:bg-muted',
    );
@endphp

<button
    type="button"
    data-slot="navigation-menu-trigger"
    x-bind:aria-expanded="(() => { const li = $el.closest('[data-nav-item-id]'); return li && openId === li.dataset.navItemId ? 'true' : 'false' })()"
    x-bind:data-open="(() => { const li = $el.closest('[data-nav-item-id]'); return li && openId === li.dataset.navItemId ? '' : null })()"
    x-bind:data-popup-open="(() => { const li = $el.closest('[data-nav-item-id]'); return li && openId === li.dataset.navItemId ? '' : null })()"
    x-on:mouseenter="triggerOnHover && openFromHover($el.closest('[data-nav-item-id]').dataset.navItemId, $el)"
    x-on:mouseleave="triggerOnHover && scheduleHoverClose()"
    x-on:click.stop="toggle($el.closest('[data-nav-item-id]').dataset.navItemId, $el)"
    {{ $attributes->class(cn($triggerStyle)) }}
>
    {{ $slot }}
    <div class="ml-2 pt-1">
        <x-livecn.phosphor-icon
            name="chevron-down"
            class="relative size-3 origin-center transition-transform duration-300 ease-out"
            x-bind:class="(() => { const li = $el.closest('[data-nav-item-id]'); return li && openId === li.dataset.navItemId ? 'rotate-180' : ''; })()"
            aria-hidden="true"
        />
    </div>
</button>
