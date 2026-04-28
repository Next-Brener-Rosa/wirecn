@props([
    'href' => '#',
    'text' => null,
    'disabled' => false,
])

@php
    $text = $text ?? (function_exists('__') ? __('pagination.previous') : 'Previous');
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp

<x-livecn.pagination.link
    :href="$href"
    size="default"
    :disabled="$disabled"
    {{ $attributes->merge(['aria-label' => $attributes->get('aria-label', 'Go to previous page')])->class(cn('!pl-1.5')) }}
>
    <x-livecn.phosphor-icon name="chevron-left" data-icon="inline-start" class="[[dir=rtl]_&]:scale-x-[-1]" />
    <span class="hidden sm:block">{{ $text }}</span>
</x-livecn.pagination.link>
