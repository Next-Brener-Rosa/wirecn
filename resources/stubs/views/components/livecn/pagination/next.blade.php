@props([
    'href' => '#',
    'text' => null,
    'disabled' => false,
])

@php
    $text = $text ?? (function_exists('__') ? __('pagination.next') : 'Next');
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp

<x-livecn.pagination.link
    :href="$href"
    size="default"
    :disabled="$disabled"
    {{ $attributes->merge(['aria-label' => $attributes->get('aria-label', 'Go to next page')])->class(cn('!pr-1.5')) }}
>
    <span class="hidden sm:block">{{ $text }}</span>
    <x-livecn.phosphor-icon name="chevron-right" data-icon="inline-end" class="[[dir=rtl]_&]:scale-x-[-1]" />
</x-livecn.pagination.link>
