<button
    type="button"
    data-slot="collapsible-trigger"
    x-on:click="open = !open"
    x-bind:aria-expanded="open.toString()"
    {{ $attributes }}
>
    {{ $slot }}
</button>
