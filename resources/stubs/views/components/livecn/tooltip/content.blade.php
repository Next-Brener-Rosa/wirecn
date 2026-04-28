@props([
    'side' => 'top',
    'align' => 'center',
    'sideOffset' => 4,
    'alignOffset' => 0,
])

@php
    $allowedSides = ['top', 'bottom', 'left', 'right', 'inline-end', 'inline-start'];
    $side = in_array($side, $allowedSides, true) ? $side : 'top';
    $allowedAlign = ['start', 'center', 'end'];
    $align = in_array($align, $allowedAlign, true) ? $align : 'center';
    $sideOffset = (int) $sideOffset;
    $alignOffset = (int) $alignOffset;
@endphp

<template x-teleport="body">
    <div data-slot="tooltip-portal">
        <div data-slot="tooltip-positioner" class="{{ cn('isolate z-50') }}">
            <div
                x-ref="floating"
                x-show="open"
                x-on:mouseenter="cancelHide()"
                x-on:mouseleave="hide()"
                role="tooltip"
                data-slot="tooltip-content"
                data-config-side="{{ $side }}"
                data-config-align="{{ $align }}"
                data-config-side-offset="{{ $sideOffset }}"
                data-config-align-offset="{{ $alignOffset }}"
                x-bind:data-open="open ? '' : null"
                x-bind:data-closed="!open ? '' : null"
                x-bind:data-state="!open ? 'closed' : (delayedState ? 'delayed-open' : 'instant-open')"
                {{ $attributes->class(cn(
                    'pointer-events-auto relative z-50 inline-flex w-fit max-w-xs origin-(--transform-origin) items-center gap-1.5 rounded-md bg-foreground px-3 py-1.5 text-xs text-background',
                    'has-data-[slot=kbd]:pr-1.5',
                    'data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2',
                    '**:data-[slot=kbd]:relative **:data-[slot=kbd]:isolate **:data-[slot=kbd]:z-50 **:data-[slot=kbd]:rounded-sm',
                    'data-[state=delayed-open]:animate-in data-[state=delayed-open]:fade-in-0 data-[state=delayed-open]:zoom-in-95',
                    'data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95',
                    'data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95',
                )) }}
            >
                {{ $slot }}
                <span
                    x-ref="tooltipArrow"
                    data-slot="tooltip-arrow"
                    aria-hidden="true"
                    class="{{ cn(
                        'pointer-events-none absolute z-50 size-2.5 translate-y-[calc(-50%-2px)] rotate-45 rounded-[2px] bg-foreground fill-foreground',
                        'data-[side=bottom]:top-1 data-[side=inline-end]:top-1/2! data-[side=inline-end]:-left-1 data-[side=inline-end]:-translate-y-1/2',
                        'data-[side=inline-start]:top-1/2! data-[side=inline-start]:-right-1 data-[side=inline-start]:-translate-y-1/2',
                        'data-[side=left]:top-1/2! data-[side=left]:-right-1 data-[side=left]:-translate-y-1/2',
                        'data-[side=right]:top-1/2! data-[side=right]:-left-1 data-[side=right]:-translate-y-1/2',
                        'data-[side=top]:-bottom-2.5',
                    ) }}"
                ></span>
            </div>
        </div>
    </div>
</template>
