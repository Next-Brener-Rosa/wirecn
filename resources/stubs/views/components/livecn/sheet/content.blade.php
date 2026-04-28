@props([
    'side' => 'right',
    'showCloseButton' => true,
])

@php
    $side = in_array($side, ['top', 'right', 'bottom', 'left'], true) ? $side : 'right';
    $showCloseButton = filter_var($showCloseButton, FILTER_VALIDATE_BOOLEAN);

    $openTransform = match ($side) {
        'top', 'bottom' => 'translate-y-0 opacity-100',
        default => 'translate-x-0 opacity-100',
    };

    $closedTransform = match ($side) {
        'left' => '-translate-x-10 opacity-0',
        'top' => '-translate-y-10 opacity-0',
        'bottom' => 'translate-y-10 opacity-0',
        default => 'translate-x-10 opacity-0',
    };
@endphp

<x-livecn.sheet.portal>
    <x-livecn.sheet.overlay />
    <div
        x-trap="open"
        x-show="open"
        x-cloak
        role="dialog"
        aria-modal="true"
        data-slot="sheet-content"
        data-side="{{ $side }}"
        x-on:click.stop
        x-bind:class="open ? '{{ $openTransform }}' : '{{ $closedTransform }}'"
        {{ $attributes->class(cn(
            'fixed z-50 flex flex-col gap-4 bg-popover bg-clip-padding text-sm text-popover-foreground shadow-lg outline-none transition duration-200 ease-in-out',
            'data-[side=bottom]:inset-x-0 data-[side=bottom]:bottom-0 data-[side=bottom]:h-auto data-[side=bottom]:border-t data-[side=bottom]:border-border',
            'data-[side=left]:inset-y-0 data-[side=left]:left-0 data-[side=left]:h-full data-[side=left]:w-3/4 data-[side=left]:border-r data-[side=left]:border-border',
            'data-[side=right]:inset-y-0 data-[side=right]:right-0 data-[side=right]:h-full data-[side=right]:w-3/4 data-[side=right]:border-l data-[side=right]:border-border',
            'data-[side=top]:inset-x-0 data-[side=top]:top-0 data-[side=top]:h-auto data-[side=top]:border-b data-[side=top]:border-border',
            'data-[side=left]:sm:max-w-sm data-[side=right]:sm:max-w-sm',
        )) }}
    >
        {{ $slot }}
        @if ($showCloseButton)
            <x-livecn.button
                type="button"
                variant="ghost"
                size="icon-sm"
                class="absolute top-3 right-3"
                data-slot="sheet-close"
                x-on:click="close()"
                aria-label="{{ __('Fechar') }}"
            >
                <x-livecn.phosphor-icon name="x" />
                <span class="sr-only">{{ __('Fechar') }}</span>
            </x-livecn.button>
        @endif
    </div>
</x-livecn.sheet.portal>
