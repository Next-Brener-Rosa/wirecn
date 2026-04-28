{{-- Chip individual (multi); lógica de remoção a definir no Alpine. --}}
<div
    data-slot="combobox-chip"
    {{ $attributes->class(cn(
        'flex h-6 w-fit items-center justify-center gap-1 rounded-sm bg-muted px-1.5 text-xs font-medium whitespace-nowrap text-foreground',
    )) }}
>
    {{ $slot }}
</div>
