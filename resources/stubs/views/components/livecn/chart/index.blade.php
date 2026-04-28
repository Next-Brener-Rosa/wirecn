@props([
    'config' => [],
    'data' => [],
    'type' => 'line',
    'id' => null,
    'indexKey' => null,
    'initialWidth' => 320,
    'initialHeight' => 200,
])

@php
    $safeId = $id !== null && $id !== ''
        ? preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $id)
        : null;
    $chartId = 'chart-'.($safeId !== null && $safeId !== '' ? $safeId : Illuminate\Support\Str::random(8));

    $configJson = json_encode($config ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?: '{}';
    $dataJson = json_encode($data ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?: '[]';
    $indexKeyAttr = $indexKey !== null && $indexKey !== '' ? (string) $indexKey : '';
@endphp

<div class="{{ cn('w-full max-w-full') }}">
    <x-livecn.chart.style :chart-id="$chartId" :config="$config" />
    <div
        data-ui-chart
        data-chart="{{ $chartId }}"
        data-chart-id="{{ $chartId }}"
        data-chart-type="{{ $type }}"
        @if ($indexKeyAttr !== '')
            data-chart-index-key="{{ $indexKeyAttr }}"
        @endif
        data-chart-config="{{ $configJson }}"
        data-chart-series="{{ $dataJson }}"
        data-chart-initial-width="{{ (int) $initialWidth }}"
        data-chart-initial-height="{{ (int) $initialHeight }}"
        data-slot="chart"
        {{ $attributes->class(cn(
            'flex aspect-video min-h-[200px] w-full justify-center text-xs [&_.recharts-cartesian-axis-tick_text]:fill-muted-foreground [&_.recharts-cartesian-grid_line]:stroke-border/50 [&_.recharts-curve.recharts-tooltip-cursor]:stroke-border [&_.recharts-dot]:stroke-transparent [&_.recharts-layer]:outline-hidden [&_.recharts-polar-grid]:stroke-border [&_.recharts-radial-bar-background-sector]:fill-muted [&_.recharts-rectangle.recharts-tooltip-cursor]:fill-muted [&_.recharts-reference-line]:stroke-border [&_.recharts-sector]:outline-hidden [&_.recharts-surface]:outline-hidden',
        )) }}
    ></div>
</div>
