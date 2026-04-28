<div
    data-slot="navigation-menu-indicator"
    role="presentation"
    x-bind:data-state="(() => { const li = $el.closest('[data-nav-item-id]'); return li && openId === li.dataset.navItemId ? 'visible' : 'hidden' })()"
    {{ $attributes->class(cn(
        'pointer-events-none absolute left-1/2 top-full z-30 -translate-x-1/2',
        'flex flex-col items-center',
        'data-[state=hidden]:invisible data-[state=hidden]:h-0 data-[state=hidden]:overflow-hidden data-[state=hidden]:opacity-0',
        'data-[state=visible]:opacity-100',
    )) }}
>
    <div
        class="mt-px size-0 border-x-[6px] border-x-transparent border-b-[7px] border-b-popover drop-shadow-sm"
        aria-hidden="true"
    ></div>
</div>
