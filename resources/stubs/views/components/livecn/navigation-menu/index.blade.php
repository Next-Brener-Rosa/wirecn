@props([
    'align' => 'start',
    'viewport' => true,
    'triggerOnHover' => false,
])

@php
    $align = in_array($align, ['start', 'center', 'end'], true) ? $align : 'start';
    $viewport = filter_var($viewport, FILTER_VALIDATE_BOOLEAN);
    $triggerOnHover = filter_var($triggerOnHover, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    x-data="uiNavigationMenu({ align: @js($align), viewport: @js($viewport), triggerOnHover: @js($triggerOnHover) })"
    data-slot="navigation-menu"
    data-trigger-on-hover="{{ $triggerOnHover ? 'true' : 'false' }}"
    data-viewport="{{ $viewport ? 'true' : 'false' }}"
    {{ $attributes->class(cn(
        'group/navigation-menu relative flex max-w-max flex-1 items-center justify-center',
    )) }}
>
    {{ $slot }}
</div>
