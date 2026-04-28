{{-- Chips multi-seleção: requer extensão do uiCombobox (estado em array). data-slot alinhado ao Base UI. --}}
<div
    data-slot="combobox-chips"
    {{ $attributes->class(cn(
        'flex min-h-8 flex-wrap items-center gap-1 rounded-lg border border-input bg-transparent bg-clip-padding px-2.5 py-1 text-sm transition-colors',
        'focus-within:border-ring focus-within:ring-3 focus-within:ring-ring/50',
        'has-aria-invalid:border-destructive has-aria-invalid:ring-3 has-aria-invalid:ring-destructive/20',
        'dark:bg-input/30 dark:has-aria-invalid:border-destructive/50 dark:has-aria-invalid:ring-destructive/40',
    )) }}
>
    {{ $slot }}
</div>
