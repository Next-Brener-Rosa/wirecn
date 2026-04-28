@props([
    'align' => 'inline-start',
])

@php
    $align = in_array($align, ['inline-start', 'inline-end', 'block-start', 'block-end'], true)
        ? $align
        : 'inline-start';

    $alignClass = match ($align) {
        'inline-end' => 'order-last pr-2 has-[>button]:mr-[-0.3rem] has-[>kbd]:mr-[-0.15rem]',
        'block-start' => 'order-first w-full justify-start px-2.5 pt-2 group-has-[>input]/input-group:pt-2 [.border-b]:pb-2',
        'block-end' => 'order-last w-full justify-start px-2.5 pb-2 group-has-[>input]/input-group:pb-2 [.border-t]:pt-2',
        default => 'order-first pl-2 has-[>button]:ml-[-0.3rem] has-[>kbd]:ml-[-0.15rem]',
    };
@endphp

<div
    role="group"
    data-slot="input-group-addon"
    data-align="{{ $align }}"
    x-on:click="
        if ($event.target.closest('button')) { return; }
        $el.closest('[data-slot=input-group]')?.querySelector('[data-slot=input-group-control]')?.focus();
    "
    {{ $attributes->class(cn(
        'flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-muted-foreground select-none',
        '[&>kbd]:rounded-[calc(var(--radius)-5px)] [&>svg:not([class*=\'size-\'])]:size-4',
        'group-data-[disabled=true]/input-group:opacity-50',
        $alignClass,
    )) }}
>
    {{ $slot }}
</div>
