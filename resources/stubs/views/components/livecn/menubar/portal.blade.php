<template x-teleport="body">
    <div data-slot="menubar-portal" {{ $attributes->class(cn('contents isolate z-50 outline-none')) }}>
        {{ $slot }}
    </div>
</template>
