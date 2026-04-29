<fieldset
    data-slot="field-set"
    {{ $attributes->class(cn(
        'flex flex-col gap-4 has-[>[data-slot=checkbox-group]]:gap-3 has-[>[data-slot=radio-group]]:gap-3',
    )) }}
>
    {{ $slot }}
</fieldset>
