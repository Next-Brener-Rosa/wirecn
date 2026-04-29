<div
    data-slot="field-label"
    {{ $attributes->class(cn(
        'flex w-fit items-center gap-2 text-sm font-medium group-data-[disabled=true]/field:opacity-50',
    )) }}
>
    {{ $slot }}
</div>
