<div
    data-slot="collapsible-content"
    x-show="open"
    x-collapse
    role="region"
    {{ $attributes->class(cn('overflow-hidden')) }}
>
    {{ $slot }}
</div>
