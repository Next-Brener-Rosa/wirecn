<div
    data-slot="empty"
    {{ $attributes->class(cn(
        'flex w-full min-w-0 flex-1 flex-col items-center justify-center gap-4 rounded-xl border border-dashed border-border p-6 text-center text-balance',
    )) }}
>
    {{ $slot }}
</div>
