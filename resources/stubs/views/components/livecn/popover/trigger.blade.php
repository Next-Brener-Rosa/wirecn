<div
    x-ref="reference"
    data-slot="popover-trigger"
    x-on:click.stop="toggle()"
    {{ $attributes }}
>
    {{ $slot }}
</div>
