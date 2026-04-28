@props([
    'size' => 'default',
])

@php
    $size = in_array($size, ['default', 'sm'], true) ? $size : 'default';
@endphp

<template x-teleport="body">
    <div
        x-show="open"
        x-cloak
        class="{{ cn('fixed inset-0 z-50') }}"
        role="presentation"
        x-on:keydown.escape.window="close()"
    >
        <x-livecn.alert-dialog.overlay />

        <div
            class="{{ cn('pointer-events-none fixed inset-0 z-50 grid place-items-center p-4') }}"
            role="presentation"
        >
            <div
                x-trap="open"
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                data-slot="alert-dialog-content"
                data-size="{{ $size }}"
                role="alertdialog"
                aria-modal="true"
                x-on:click.stop
                x-init="$watch('open', (value) => { if (! value) { return; } $nextTick(() => { const t = $el.querySelector('[data-slot=alert-dialog-title]'); const d = $el.querySelector('[data-slot=alert-dialog-description]'); if (t && t.id) { $el.setAttribute('aria-labelledby', t.id); } else { $el.removeAttribute('aria-labelledby'); } if (d && d.id) { $el.setAttribute('aria-describedby', d.id); } else { $el.removeAttribute('aria-describedby'); } }); })"
                {{ $attributes->class(cn(
                    'group/alert-dialog-content pointer-events-auto relative z-50 grid w-full max-w-xs gap-4 rounded-xl border border-border bg-popover p-4 text-popover-foreground shadow-lg ring-1 ring-foreground/10 outline-none',
                    'data-[size=default]:sm:max-w-sm',
                )) }}
            >
                {{ $slot }}
            </div>
        </div>
    </div>
</template>
