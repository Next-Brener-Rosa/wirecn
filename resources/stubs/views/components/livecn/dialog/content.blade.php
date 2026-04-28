@props([
    'showCloseButton' => true,
])

@php
    $showCloseButton = filter_var($showCloseButton, FILTER_VALIDATE_BOOLEAN);
@endphp

<x-livecn.dialog.portal>
    <x-livecn.dialog.overlay />
    <div
        x-trap="open"
        x-show="open"
        x-cloak
        x-transition
        role="dialog"
        aria-modal="true"
        data-slot="dialog-content"
        data-testid="dialog-content"
        x-on:click.stop
        x-bind:data-open="open ? '' : null"
        {{ $attributes->class(cn(
            'fixed top-1/2 left-1/2 z-50 grid w-full max-w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 gap-4 rounded-xl bg-popover p-4 text-sm text-popover-foreground ring-1 ring-foreground/10 duration-100 outline-none',
            'sm:max-w-sm',
            'data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95',
            'data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95',
        )) }}
    >
        {{ $slot }}
        @if ($showCloseButton)
            <x-livecn.button
                type="button"
                variant="ghost"
                size="icon-sm"
                class="absolute top-2 right-2"
                data-slot="dialog-close"
                x-on:click="close()"
                aria-label="{{ __('Fechar') }}"
            >
                <x-livecn.phosphor-icon name="x" />
                <span class="sr-only">{{ __('Fechar') }}</span>
            </x-livecn.button>
        @endif
    </div>
</x-livecn.dialog.portal>
