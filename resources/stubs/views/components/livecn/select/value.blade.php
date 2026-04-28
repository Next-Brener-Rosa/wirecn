<span data-slot="select-value" {{ $attributes->class(cn('flex min-w-0 flex-1 items-center gap-1.5 text-left')) }}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        <span
            x-text="displayLabel"
            x-bind:class="(! selectedValue || selectedValue === '') ? 'text-muted-foreground' : ''"
        ></span>
    @endif
</span>
