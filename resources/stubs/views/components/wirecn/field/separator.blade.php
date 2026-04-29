@php
    $hasContent = ! $slot->isEmpty();
@endphp

<div
    data-slot="field-separator"
    data-content="{{ $hasContent ? 'true' : 'false' }}"
    {{ $attributes->class(cn(
        'relative -my-2 h-5 text-sm group-data-[variant=outline]/field-group:-mb-2',
    )) }}
>
    <x-wirecn.separator class="absolute inset-0 top-1/2" />
    @if ($hasContent)
        <span
            class="{{ cn(
                'relative mx-auto block w-fit bg-background px-2 text-muted-foreground',
            ) }}"
            data-slot="field-separator-content"
        >
            {{ $slot }}
        </span>
    @endif
</div>
