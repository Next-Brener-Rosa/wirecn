@props([
    'size' => 'default',
])

@php
    $size = in_array($size, ['sm', 'default', 'lg'], true) ? $size : 'default';
@endphp

<span
    data-slot="avatar"
    data-size="{{ $size }}"
    {{ $attributes->class(cn(
        'group/avatar relative flex size-8 shrink-0 select-none rounded-full',
        'after:pointer-events-none after:absolute after:inset-0 after:rounded-full after:border after:border-border after:mix-blend-darken dark:after:mix-blend-lighten',
        'data-[size=lg]:size-10 data-[size=sm]:size-6',
    )) }}
>
    {{ $slot }}
</span>
