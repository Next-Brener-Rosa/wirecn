@php
    $openBoundToLivewire = ! $attributes->whereStartsWith('wire:model')->isEmpty();
@endphp
@if ($openBoundToLivewire)
    <div
        data-slot="sheet"
        x-data="{
            open: @entangle($attributes->wire('model')),
            close() {
                this.open = false;
            },
        }"
        {{ $attributes->whereDoesntStartWith('wire:model')->class(cn('relative')) }}
    >
        {{ $slot }}
    </div>
@else
    <div x-data="uiDialog()" data-slot="sheet" {{ $attributes->class(cn('relative')) }}>
        {{ $slot }}
    </div>
@endif
