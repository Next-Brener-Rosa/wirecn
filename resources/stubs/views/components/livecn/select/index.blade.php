@props([
    'name' => null,
    'value' => null,
    'placeholder' => '',
    'disabled' => false,
    'invalid' => false,
])

@php
    $wireAttributes = $attributes->whereStartsWith('wire:');
    $wireKeys = array_keys($wireAttributes->getAttributes());

    $name = $name ?? $attributes->get('name');
    $triggerId = $attributes->get('id') ?? 'ui-select-'.Illuminate\Support\Str::random(8);
    $listboxId = $triggerId.'-listbox';
    $initial = $value ?? ($name ? old($name) : null);

    $forHidden = new \Illuminate\View\ComponentAttributeBag(array_merge(
        $attributes->only(['required', 'form', 'autocomplete'])->getAttributes(),
        $wireAttributes->getAttributes()
    ));

    $rootAttributes = $attributes->except(array_merge($wireKeys, ['name', 'required', 'form', 'autocomplete', 'value', 'id']));

    $uiSelectConfig = [
        'initialValue' => $initial,
        'placeholder' => $placeholder,
        'disabled' => (bool) $disabled,
        'invalid' => (bool) $invalid,
        'triggerId' => $triggerId,
        'listboxId' => $listboxId,
    ];
@endphp

<div
    data-slot="select"
    x-data="uiSelect({{ \Illuminate\Support\Js::from($uiSelectConfig) }})"
    x-on:keydown="onKeydown($event)"
    x-on:keydown.escape.window="close()"
    x-on:mousedown.outside="close()"
    {{ $rootAttributes->class(cn('relative w-full')) }}
>
    <input
        type="hidden"
        x-ref="hiddenInput"
        value="{{ $initial === null || $initial === '' ? '' : $initial }}"
        @isset($name)
            name="{{ $name }}"
        @endisset
        {{ $forHidden }}
    />

    {{ $slot }}
</div>
