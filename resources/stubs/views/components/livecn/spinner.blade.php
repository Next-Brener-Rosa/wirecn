@php
    $ariaLabel = $attributes->get('aria-label', __('A carregar'));
@endphp

<x-livecn.phosphor-icon name="loader-2"
    data-slot="spinner"
    role="status"
    aria-label="{{ $ariaLabel }}"
    {{ $attributes->except('aria-label')->class(cn('size-4 shrink-0 animate-spin')) }}
/>
