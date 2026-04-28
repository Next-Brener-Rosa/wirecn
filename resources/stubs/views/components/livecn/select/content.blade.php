<div
    x-show="panelOpen"
    x-cloak
    role="presentation"
    data-slot="select-content"
    x-on:click="$event.stopPropagation()"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    {{ $attributes->class(cn(
        'absolute left-0 z-50 mt-1 w-full min-w-36 overflow-hidden rounded-lg border border-border bg-popover text-popover-foreground shadow-md ring-1 ring-foreground/10 dark:ring-border/60',
    )) }}
>
    <x-livecn.select.scroll-up-button />
    <div
        x-ref="viewport"
        data-slot="select-viewport"
        x-bind:id="listboxId"
        role="listbox"
        tabindex="-1"
        x-on:keydown.stop="onListboxKeydown($event)"
        x-on:scroll.passive="updateScrollAffordances()"
        class="{{ cn('max-h-60 scroll-my-1 overflow-x-hidden overflow-y-auto p-1 outline-none') }}"
    >
        {{ $slot }}
    </div>
    <x-livecn.select.scroll-down-button />
</div>
