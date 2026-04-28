<div
    x-ref="reference"
    data-slot="dropdown-menu-trigger"
    x-on:click.stop="toggle()"
    {{ $attributes }}
>
    {{ $slot }}
</div>
