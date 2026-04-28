@props([
    'showCloseButton' => false,
])

@php
    $showCloseButton = filter_var($showCloseButton, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    data-slot="dialog-footer"
    {{ $attributes->class(cn(
        '-mx-4 -mb-4 flex flex-col-reverse gap-2 rounded-b-xl border-t border-border bg-muted/50 p-4 sm:flex-row sm:justify-end',
    )) }}
>
    {{ $slot }}
    @if ($showCloseButton)
        <x-livecn.button
            type="button"
            variant="outline"
            data-slot="dialog-close"
            x-on:click="close()"
        >
            {{ __('Fechar') }}
        </x-livecn.button>
    @endif
</div>
