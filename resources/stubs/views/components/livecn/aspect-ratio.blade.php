@props([
    /** Proporção CSS: número (ex.: 1.777…) ou fração (ex.: `16 / 9`). */
    'ratio' => 16 / 9,
])

@php
    $ratioCss = is_numeric($ratio)
        ? (string) (float) $ratio
        : trim((string) $ratio);
    $userStyle = $attributes->get('style');
    $style = '--ratio: '.$ratioCss.';'.($userStyle ? ' '.$userStyle : '');
@endphp

<div
    data-slot="aspect-ratio"
    {{ $attributes->except('style')->class(cn('relative w-full overflow-hidden rounded-md aspect-[var(--ratio)]')) }}
    style="{{ e($style) }}"
>
    {{ $slot }}
</div>
