@props([
    'variant' => 'default',
    'href' => null,
])

@php
    $variant = in_array($variant, ['default', 'secondary', 'destructive', 'outline', 'ghost', 'link'], true)
        ? $variant
        : 'default';

    $base = 'group/badge inline-flex h-5 w-fit shrink-0 items-center justify-center gap-1 overflow-hidden rounded-4xl border border-transparent px-2 py-0.5 text-xs font-medium whitespace-nowrap transition-all focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 has-data-[icon=inline-end]:pr-1.5 has-data-[icon=inline-start]:pl-1.5 aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 [&_svg]:pointer-events-none [&_svg]:!size-3';

    $variants = [
        'default' => 'bg-primary text-primary-foreground [&_a]:hover:bg-primary/80',
        'secondary' => 'bg-secondary text-secondary-foreground [&_a]:hover:bg-secondary/80',
        'destructive' => 'bg-destructive/10 text-destructive focus-visible:ring-destructive/20 dark:bg-destructive/20 dark:focus-visible:ring-destructive/40 [&_a]:hover:bg-destructive/20',
        'outline' => 'border-border text-foreground [&_a]:hover:bg-muted [&_a]:hover:text-muted-foreground',
        'ghost' => 'hover:bg-muted hover:text-muted-foreground dark:hover:bg-muted/50',
        'link' => 'text-primary underline-offset-4 hover:underline',
    ];

    $rootHover = $href ? match ($variant) {
        'default' => 'hover:bg-primary/80',
        'secondary' => 'hover:bg-secondary/80',
        'destructive' => 'hover:bg-destructive/20',
        'outline' => 'hover:bg-muted hover:text-muted-foreground',
        default => '',
    } : '';

    $classes = cn($base, $variants[$variant], $rootHover);
@endphp

@if ($href)
    <a
        data-slot="badge"
        href="{{ $href }}"
        {{ $attributes->class($classes) }}
    >
        {{ $slot }}
    </a>
@else
    <span data-slot="badge" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </span>
@endif
