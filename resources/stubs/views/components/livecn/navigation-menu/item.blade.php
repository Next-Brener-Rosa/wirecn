@props([
    'id' => null,
])

@php
    $navItemId = $id ?? 'nm-'.substr(str_replace('.', '', uniqid('', true)), 0, 10);
@endphp

<li
    data-slot="navigation-menu-item"
    data-nav-item-id="{{ $navItemId }}"
    {{ $attributes->class(cn('relative min-w-0')) }}
>
    {{ $slot }}
</li>
