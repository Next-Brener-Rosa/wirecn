@props([
    'variant' => 'default',
    'size' => 'default',
    'tag' => 'div',
])

@php
    $variant = in_array($variant, ['default', 'outline', 'muted'], true) ? $variant : 'default';
    $size = in_array($size, ['default', 'sm', 'xs'], true) ? $size : 'default';

    $allowedTags = ['div', 'a', 'button', 'li', 'article', 'section'];
    $rootTag = in_array($tag, $allowedTags, true) ? $tag : 'div';

    $base = 'group/item flex w-full flex-wrap items-center rounded-lg border text-sm transition-colors duration-100 outline-none focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 [a]:transition-colors [a]:hover:bg-muted';

    $variants = [
        'default' => 'border-transparent',
        'outline' => 'border-border',
        'muted' => 'border-transparent bg-muted/50',
    ];

    $sizes = [
        'default' => 'gap-2.5 px-3 py-2.5',
        'sm' => 'gap-2.5 px-3 py-2.5',
        'xs' => 'gap-2 px-2.5 py-2 in-data-[slot=dropdown-menu-content]:p-0',
    ];

    $classes = cn($base, $variants[$variant], $sizes[$size]);
@endphp

<{{ $rootTag }}
    data-slot="item"
    data-size="{{ $size }}"
    data-variant="{{ $variant }}"
    {{ $attributes->class($classes) }}
>
    {{ $slot }}
</{{ $rootTag }}>
