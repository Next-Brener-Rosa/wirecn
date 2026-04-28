@props([
    'value' => '',
])

@php
    $valueJson = json_encode((string) $value, JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
@endphp

<div
    x-show="open === {{ $valueJson }}"
    x-collapse
    role="region"
    data-slot="accordion-content"
    {{ $attributes->class(cn('overflow-hidden text-sm')) }}
>
    <div
        class="{{ cn(
            'pt-0 pb-2.5 [&_a]:underline [&_a]:underline-offset-[3px] [&_a]:hover:text-foreground [&_p:not(:last-child)]:mb-4',
        ) }}"
    >
        {{ $slot }}
    </div>
</div>
