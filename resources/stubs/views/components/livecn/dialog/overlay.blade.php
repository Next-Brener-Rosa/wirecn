<div
    data-slot="dialog-overlay"
    data-testid="dialog-overlay"
    x-show="open"
    x-cloak
    x-transition.opacity.duration.100ms
    x-bind:data-open="open ? '' : null"
    aria-hidden="true"
    x-on:click="close()"
    {{ $attributes->class(cn(
        'fixed inset-0 isolate z-50 bg-black/10 duration-100 supports-[backdrop-filter]:backdrop-blur-sm',
        'data-open:animate-in data-open:fade-in-0 data-closed:animate-out data-closed:fade-out-0',
    )) }}
></div>
