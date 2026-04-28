@props([
    'items' => [],
    'name' => null,
    'value' => null,
    'disabled' => false,
])

@php
    $wireAttributes = $attributes->whereStartsWith('wire:');
    $wireKeyBag = $attributes->whereStartsWith('wire:key');
    $wireBindingsForHidden = $wireAttributes->except(array_keys($wireKeyBag->getAttributes()));
    $wireKeysForHidden = array_keys($wireBindingsForHidden->getAttributes());

    $name = $name ?? $attributes->get('name');
    $initial = $value ?? ($name ? old($name) : null);
    $initialString = $initial === null || $initial === '' ? '' : (string) $initial;

    $forHidden = new \Illuminate\View\ComponentAttributeBag(array_merge(
        $attributes->only(['required', 'form', 'autocomplete'])->getAttributes(),
        $wireBindingsForHidden->getAttributes()
    ));

    $stripFromRoot = array_merge($wireKeysForHidden, ['name', 'required', 'form', 'autocomplete', 'value']);
    $rootAttributes = $attributes->except($stripFromRoot);

    if ($wireKeyBag->isEmpty() && ($name !== null && $name !== '')) {
        $rootAttributes = $rootAttributes->merge(['wire:key' => 'combobox-'.$name]);
    } else {
        $rootAttributes = $rootAttributes->merge($wireKeyBag->all());
    }

    $itemsArray = array_values($items);
    $needsHidden = ($name !== null && $name !== '') || $forHidden->isNotEmpty();
@endphp

<div
    x-data="uiCombobox({ items: @js($itemsArray), disabled: @js((bool) $disabled), initialValue: @js($initialString) })"
    data-slot="combobox"
    {{ $rootAttributes->class(cn('relative w-full max-w-sm')) }}
    x-on:keydown="onKeydown($event)"
>
    @if ($needsHidden)
        <input
            type="hidden"
            x-ref="hiddenInput"
            value="{{ $initialString }}"
            @if ($name !== null && $name !== '')
                name="{{ $name }}"
            @endif
            {{ $forHidden }}
        />
    @endif
    {{ $slot }}
</div>
