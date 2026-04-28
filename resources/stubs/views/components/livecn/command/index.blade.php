@props([
    'groups' => [],
    'items' => null,
])

@php
    $groupsPayload = $groups;

    if ($items !== null && $groupsPayload === []) {
        $groupsPayload = [['heading' => null, 'items' => array_values($items)]];
    }

    $groupsPayload = array_values($groupsPayload);
@endphp

<div
    x-data="uiCommand({ groups: @js($groupsPayload) })"
    data-slot="command"
    x-on:keydown="onKeydown($event)"
    {{ $attributes->class(cn(
        'flex size-full flex-col overflow-hidden rounded-xl! bg-popover p-1 text-popover-foreground',
    )) }}
>
    {{ $slot }}
</div>
