@props([
    'heading' => null,
])

<div
    data-slot="command-group"
    role="group"
    {{ $attributes->class(cn(
        'overflow-hidden p-1 text-foreground',
        '[&_.cmdk-group-heading]:px-2 [&_.cmdk-group-heading]:py-1.5 [&_.cmdk-group-heading]:text-xs [&_.cmdk-group-heading]:font-medium [&_.cmdk-group-heading]:text-muted-foreground',
    )) }}
>
    @if ($heading)
        <div class="cmdk-group-heading">{{ $heading }}</div>
    @endif
    {{ $slot }}
</div>
