@php
    $__selectListboxViewport = new \Illuminate\View\ComponentAttributeBag([
        'x-bind:id' => 'listboxId',
        'role' => 'listbox',
        'tabindex' => '-1',
        'x-on:keydown.stop' => 'onListboxKeydown($event)',
        'x-on:scroll.passive' => 'updateScrollAffordances()',
        'class' => 'scroll-my-1 overflow-x-hidden p-1 outline-none',
    ]);

    $__selectPanelClass = cn(
        'fixed z-[100] flex min-h-0 max-h-[min(24rem,calc(100dvh-2rem))] min-w-[9rem] flex-col overscroll-contain overflow-hidden rounded-lg border border-border bg-popover text-popover-foreground shadow-md ring-1 ring-foreground/10 dark:ring-border/60',
        $attributes->get('class'),
    );
@endphp

<template x-teleport="body">
    <div
        wire:ignore
        x-ref="floatingPanel"
        x-show="panelOpen"
        x-cloak
        role="presentation"
        data-slot="select-content"
        x-on:click="$event.stopPropagation()"
        x-on:transitionend="onFloatingPanelTransitionEnd($event)"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        {{ $attributes->except('class')->class($__selectPanelClass) }}
    >
        <x-wirecn.select.scroll-up-button />
        <x-wirecn.scroll-area
            viewport-ref="viewport"
            :viewport-attributes="$__selectListboxViewport"
            class="min-h-0 min-w-0 flex-1"
        >
            {{ $slot }}
        </x-wirecn.scroll-area>
        <x-wirecn.select.scroll-down-button />
    </div>
</template>
