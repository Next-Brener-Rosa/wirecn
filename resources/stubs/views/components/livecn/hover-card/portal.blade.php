<template x-teleport="body">
    <div data-slot="hover-card-portal" {{ $attributes->class(cn('contents isolate z-50')) }}>
        {{ $slot }}
    </div>
</template>
