@props([
    'side' => 'bottom',
    'sideOffset' => 8,
    'align' => 'start',
    'alignOffset' => 0,
])

{{-- Portal + casca visual alinhada ao Base UI; o painel ativo costuma ser posicionado via uiNavigationMenu + Floating UI no content. --}}
<template x-teleport="body">
    <div
        data-slot="navigation-menu-positioner"
        {{ $attributes->class(cn(
            'isolate z-50 transition-[top,left,right,bottom] duration-[0.35s] ease-[cubic-bezier(0.22,1,0.36,1)] data-instant:transition-none',
            'data-[side=bottom]:before:pointer-events-none data-[side=bottom]:before:absolute data-[side=bottom]:before:top-[-10px] data-[side=bottom]:before:right-0 data-[side=bottom]:before:left-0 data-[side=bottom]:before:h-2.5',
        )) }}
    >
        <div
            data-slot="navigation-menu-popup"
            class="relative h-full w-full origin-top rounded-lg bg-popover text-popover-foreground shadow ring-1 ring-foreground/10 outline-none transition-[opacity,transform,width,height,scale,translate] duration-[0.35s] ease-[cubic-bezier(0.22,1,0.36,1)] data-ending-style:scale-90 data-ending-style:opacity-0 data-ending-style:duration-150 data-starting-style:scale-90 data-starting-style:opacity-0"
        >
            <div data-slot="navigation-menu-viewport" class="relative size-full overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </div>
</template>
