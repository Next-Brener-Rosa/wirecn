<div
    data-slot="alert-dialog-overlay"
    x-show="open"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    aria-hidden="true"
    {{ $attributes->class(cn(
        'fixed inset-0 isolate z-50 bg-black/10 supports-backdrop-filter:backdrop-blur-sm',
    )) }}
></div>
