<button
    type="button"
    data-slot="combobox-clear"
    x-bind:disabled="disabled"
    x-show="query.length > 0"
    x-cloak
    x-on:click.prevent="clear()"
    aria-label="{{ __('Limpar') }}"
    {{ $attributes->class(cn(
        'inline-flex size-7 shrink-0 items-center justify-center rounded-md border-0 bg-transparent text-muted-foreground hover:bg-muted hover:text-foreground',
    )) }}
>
    <x-livecn.phosphor-icon name="x" class="pointer-events-none size-3.5" />
</button>
