@props([
    'value' => '',
])

@php
    $idBase = \Illuminate\Support\Str::slug($value);
    $panelId = 'tabpanel-'.$idBase;
    $tabId = 'tab-'.$idBase;
    $valueJson = json_encode($value, JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

<div
    role="tabpanel"
    id="{{ $panelId }}"
    data-slot="tabs-content"
    aria-labelledby="{{ $tabId }}"
    tabindex="0"
    x-show="active === {{ $valueJson }}"
    x-cloak
    {{ $attributes->class(cn('flex-1 text-sm outline-none')) }}
>
    {{ $slot }}
</div>
