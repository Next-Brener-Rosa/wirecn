@props([
    'value' => null,
    'max' => 100,
])

<span
    data-slot="progress-value"
    {{ $attributes->class(cn(
        'ml-auto text-sm text-muted-foreground tabular-nums',
    )) }}
>@if (trim((string) $slot) !== '')
        {{ $slot }}
    @else
        @php
            $v = max(0, min((int) $max, (int) ($value ?? 0)));
            $pct = (int) $max > 0 ? round(($v / (int) $max) * 100) : 0;
        @endphp
        {{ $pct }}%
    @endif
</span>
