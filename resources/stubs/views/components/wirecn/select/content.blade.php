@php
    $__selectListboxViewport = new \Illuminate\View\ComponentAttributeBag([
        'x-bind:id' => 'listboxId',
        'role' => 'listbox',
        'tabindex' => '-1',
        'x-on:keydown.stop' => 'onListboxKeydown($event)',
        'x-on:scroll.passive' => 'updateScrollAffordances()',
        'class' => 'scroll-my-1 overflow-x-hidden p-1 outline-none',
    ]);
@endphp

<div
    wire:ignore
    x-ref="selectPanel"
    x-show="panelOpen"
    x-cloak
    role="presentation"
    data-slot="select-content"
    x-on:click="$event.stopPropagation()"
    x-transition
    {{ $attributes->class(cn(
        'absolute top-full left-0 z-50 mt-1.5 flex min-h-0 max-h-[min(18rem,calc(100vh-8rem))] w-full min-w-full origin-top flex-col overscroll-contain overflow-hidden rounded-lg border border-border bg-popover text-popover-foreground shadow-md ring-1 ring-foreground/10 dark:ring-border/60',
    )) }}
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
