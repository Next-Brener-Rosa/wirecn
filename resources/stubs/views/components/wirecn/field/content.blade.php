<div
    data-slot="field-content"
    {{ $attributes->class(cn(
        'group/field-content flex flex-1 flex-col gap-0.5 leading-snug',
    )) }}
>
    {{ $slot }}
</div>
