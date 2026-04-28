<div
    data-slot="combobox-content"
    wire:ignore
    x-show="open"
    x-cloak
    x-transition
    {{ $attributes->class(cn(
        'absolute top-full left-0 z-50 mt-1.5 max-h-[min(18rem,calc(100vh-8rem))] w-full min-w-full origin-top overflow-hidden rounded-lg bg-popover text-popover-foreground shadow-md ring-1 ring-foreground/10',
    )) }}
>
    {{ $slot }}
</div>
