@props([
    'chartId' => '',
    'config' => [],
])

@php
    $themes = [
        'light' => ['prefix' => '', 'key' => 'light'],
        'dark' => ['prefix' => '.dark ', 'key' => 'dark'],
    ];

    $colorConfig = collect($config ?? [])->filter(function ($item) {
        return is_array($item) && (isset($item['theme']) || isset($item['color']));
    });
@endphp

@if ($colorConfig->isNotEmpty())
    <style>
        @foreach ($themes as $t)
            {!! $t['prefix'] !!}[data-chart="{{ $chartId }}"] {
            @foreach ($colorConfig as $key => $item)
                @php
                    $color = $item['theme'][$t['key']] ?? ($item['color'] ?? null);
                @endphp
                @if ($color)
                --color-{{ $key }}: {{ $color }};
                @endif
            @endforeach
            }
        @endforeach
    </style>
@endif
