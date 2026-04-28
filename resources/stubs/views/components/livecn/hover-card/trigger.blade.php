<div
    x-ref="reference"
    data-slot="hover-card-trigger"
    x-on:mouseenter="show()"
    x-on:mouseleave="hide()"
    x-on:focusin="show()"
    x-on:focusout="hide()"
    {{ $attributes }}
>
    {{ $slot }}
</div>
