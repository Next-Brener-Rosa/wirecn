@props([
    'align' => 'start',
    'alignOffset' => 4,
    'side' => 'right',
    'sideOffset' => 0,
])

@php
    $alignOffset = (int) $alignOffset;
    $sideOffset = (int) $sideOffset;
@endphp

<div
    x-data="uiContextMenu({ align: @js($align), alignOffset: @js($alignOffset), side: @js($side), sideOffset: @js($sideOffset) })"
    data-slot="context-menu"
    x-on:keydown.escape.window="close()"
    x-on:contextmenu.window="outerContextMenu($event)"
    {{ $attributes->class(cn('relative')) }}
>
    <div x-ref="trigger" x-on:contextmenu.prevent.stop="openAt($event)">
        {{ $trigger }}
    </div>

    <template x-teleport="body">
        <div
            x-ref="floating"
            x-show="open"
            x-cloak
            x-transition.opacity
            data-slot="context-menu-positioner"
            class="{{ cn('isolate z-50 outline-none') }}"
            x-on:click.outside="close()"
            x-on:click="handleFloatingClick($event)"
        >
            {{ $content }}
        </div>
    </template>
</div>
