<div
    x-ref="reference"
    data-slot="menubar-trigger"
    x-bind:aria-expanded="open ? 'true' : 'false'"
    x-bind:aria-haspopup="true"
    x-on:click.stop="toggle()"
    {{ $attributes->class(cn(
        'flex items-center rounded-sm px-1.5 py-[2px] text-sm font-medium outline-hidden select-none hover:bg-muted aria-expanded:bg-muted',
    )) }}
>
    {{ $slot }}
</div>
