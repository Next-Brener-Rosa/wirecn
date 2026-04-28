<template x-teleport="body">
    <div
        x-ref="floating"
        x-show="open"
        x-cloak
        class="isolate z-50"
        x-on:click.outside="close()"
    >
        <div
            role="dialog"
            tabindex="-1"
            data-slot="popover-content"
            x-bind:data-open="open ? '' : null"
            x-bind:data-side="side"
            x-transition
            x-bind:data-closed="open ? null : ''"
            {{ $attributes->class(cn(
                'z-50 flex w-72 origin-top flex-col gap-2.5 rounded-lg bg-popover p-2.5 text-sm text-popover-foreground shadow-md ring-1 ring-foreground/10 outline-hidden duration-100',
                'data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95',
                'data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95',
                'data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2',
            )) }}
        >
            {{ $slot }}
        </div>
    </div>
</template>
