<div
    data-slot="avatar-group"
    {{ $attributes->class(cn(
        'group/avatar-group flex -space-x-2 *:data-[slot=avatar]:ring-2 *:data-[slot=avatar]:ring-background',
    )) }}
>
    {{ $slot }}
</div>
