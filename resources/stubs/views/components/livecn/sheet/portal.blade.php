<template x-teleport="body">
    <div
        data-slot="sheet-portal"
        class="contents"
        x-on:keydown.escape.window="open && close()"
        {{ $attributes }}
    >
        {{ $slot }}
    </div>
</template>
