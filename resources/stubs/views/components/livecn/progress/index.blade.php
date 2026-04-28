@props([
    'value' => 0,
    'max' => 100,
    'auto' => true,
])

@php
    $value = max(0, min((int) $max, (int) $value));
    $pct = (int) $max > 0 ? round(($value / (int) $max) * 100) : 0;
    $auto = filter_var($auto, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    data-slot="progress"
    role="progressbar"
    aria-valuemin="0"
    aria-valuemax="{{ (int) $max }}"
    aria-valuenow="{{ $value }}"
    aria-valuetext="{{ $pct }}%"
    {{ $attributes->class(cn(
        'flex flex-wrap gap-3',
    )) }}
>
    {{ $slot }}
    @if ($auto)
        <x-livecn.progress.track>
            <x-livecn.progress.indicator style="width: {{ $pct }}%;" />
        </x-livecn.progress.track>
    @endif
</div>
