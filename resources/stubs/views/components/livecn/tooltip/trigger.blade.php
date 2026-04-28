<div
    x-ref="reference"
    data-slot="tooltip-trigger"
    x-on:mouseenter="show()"
    x-on:mouseleave="hide()"
    x-on:focusin="show()"
    x-on:focusout="hide()"
    {{ $attributes }}
>
    {{ $slot }}
</div>
