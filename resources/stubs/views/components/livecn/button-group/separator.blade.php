@props([
    'orientation' => 'vertical',
])

<x-livecn.separator
    data-slot="button-group-separator"
    :orientation="$orientation"
    {{ $attributes->class(cn(
        'relative self-stretch bg-input data-[orientation=horizontal]:mx-px data-[orientation=horizontal]:w-auto data-[orientation=vertical]:my-px data-[orientation=vertical]:h-auto',
    )) }}
/>
