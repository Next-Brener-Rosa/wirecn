<div
    data-slot="scroll-area"
    {{ $attributes->class(cn(
        'relative flex min-h-0 flex-col overflow-hidden',
    )) }}
>
    <div
        data-slot="scroll-area-viewport"
        tabindex="0"
        class="{{ cn(
            'min-h-0 w-full flex-1 overflow-auto overscroll-contain rounded-[inherit] transition-[color,box-shadow] outline-none',
            'focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:outline-1',
            '[scrollbar-width:thin] [scrollbar-color:var(--border)_transparent]',
        ) }}"
    >
        {{ $slot }}
    </div>
</div>
