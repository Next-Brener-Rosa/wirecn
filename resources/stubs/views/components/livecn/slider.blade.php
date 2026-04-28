@props([
    'min' => 0,
    'max' => 100,
    'defaultValue' => null,
    'value' => null,
    'step' => null,
    'disabled' => false,
    'orientation' => 'horizontal',
    'name' => null,
])

@php
    $min = (float) $min;
    $max = (float) $max;
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $orientation = $orientation === 'vertical' ? 'vertical' : 'horizontal';
    $isVertical = $orientation === 'vertical';

    if ($value !== null) {
        $sliderValues = is_array($value) ? $value : [$value];
    } elseif ($defaultValue !== null) {
        $sliderValues = is_array($defaultValue) ? $defaultValue : [$defaultValue];
    } else {
        $sliderValues = [($min + $max) / 2];
    }

    $sliderValues = array_values(array_map(static fn ($v) => (float) $v, $sliderValues));

    foreach ($sliderValues as $i => $v) {
        $sliderValues[$i] = max($min, min($max, $v));
    }

    if (count($sliderValues) === 2 && $sliderValues[0] > $sliderValues[1]) {
        $sliderValues = [$sliderValues[1], $sliderValues[0]];
    }

    $stepJson = $step === null || $step === '' ? null : (float) $step;
@endphp

<div
    x-data="uiSlider({
        values: @js($sliderValues),
        min: @js($min),
        max: @js($max),
        step: @js($stepJson),
        disabled: @js($disabled),
        orientation: @js($orientation),
    })"
    data-slot="slider"
    @if ($isVertical)
        data-vertical
    @else
        data-horizontal
    @endif
    {{ $attributes->class(cn('data-horizontal:w-full data-vertical:h-full')) }}
>
    <div
        data-slot="slider-control"
        x-bind:data-disabled="disabled ? '' : null"
        @class([
            'relative flex touch-none select-none data-disabled:opacity-50',
            'w-full items-center data-horizontal:w-full' => ! $isVertical,
            'h-full min-h-40 w-auto flex-col data-vertical:h-full data-vertical:min-h-40 data-vertical:w-auto' => $isVertical,
        ])
    >
        <div @class([
            'relative flex-1',
            'w-full py-2' => ! $isVertical,
            'flex h-full w-full items-stretch justify-center px-2' => $isVertical,
        ])>
            <div
                x-ref="track"
                data-slot="slider-track"
                x-on:pointerdown="onTrackPointerDown($event)"
                @class([
                    'relative grow cursor-pointer overflow-hidden rounded-full bg-muted select-none',
                    'h-1 w-full data-horizontal:h-1 data-horizontal:w-full' => ! $isVertical,
                    'h-full w-1 data-vertical:h-full data-vertical:w-1' => $isVertical,
                ])
            >
                <div
                    data-slot="slider-range"
                    @class([
                        'absolute bg-primary select-none',
                        'top-0 left-0 h-full data-horizontal:h-full' => ! $isVertical,
                        'bottom-0 left-0 w-full data-vertical:w-full' => $isVertical,
                    ])
                    x-bind:style="orientation === 'vertical' ? verticalRangeStyle() : horizontalRangeStyle()"
                ></div>
            </div>
            <template x-for="(thumbValue, index) in values" :key="index">
                <button
                    type="button"
                    data-slot="slider-thumb"
                    x-bind:disabled="disabled"
                    x-on:pointerdown="onThumbPointerDown(index, $event)"
                    x-on:keydown="onKeydown(index, $event)"
                    x-bind:style="orientation === 'vertical' ? thumbVerticalStyle(index) : thumbHorizontalStyle(index)"
                    x-bind:aria-valuemin="min"
                    x-bind:aria-valuemax="max"
                    x-bind:aria-valuenow="values[index]"
                    x-bind:aria-orientation="orientation"
                    role="slider"
                    tabindex="0"
                    class="{{ cn(
                        'absolute z-10 block size-3 shrink-0 rounded-full border border-ring bg-background ring-ring/50 transition-[color,box-shadow] select-none',
                        'after:absolute after:-inset-2 hover:ring-3 focus-visible:ring-3 focus-visible:outline-hidden active:ring-3',
                        'disabled:pointer-events-none disabled:opacity-50',
                    ) }}"
                    x-bind:class="orientation === 'vertical'
                        ? '-translate-x-1/2 translate-y-1/2'
                        : '-translate-x-1/2 -translate-y-1/2'"
                ></button>
            </template>
        </div>
    </div>
    @if ($name !== null)
        <template x-for="(v, index) in values" :key="'hidden-' + index">
            <input type="hidden" name="{{ $name }}[]" x-bind:value="values[index]" />
        </template>
    @endif
</div>
