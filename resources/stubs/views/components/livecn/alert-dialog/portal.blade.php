<template x-teleport="body">
    <div x-show="open" x-cloak {{ $attributes->class(cn('fixed inset-0 z-50')) }} role="presentation">
        {{ $slot }}
    </div>
</template>
