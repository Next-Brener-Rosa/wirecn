@props([
    'variant' => 'default',
    'size' => 'default',
    'spacing' => 0,
    'orientation' => 'horizontal',
    'type' => 'single',
    'default' => null,
])

@php
    $variant = in_array($variant, ['default', 'outline'], true) ? $variant : 'default';
    $size = in_array($size, ['default', 'sm', 'lg'], true) ? $size : 'default';
    $spacing = (int) $spacing;
    $orientation = $orientation === 'vertical' ? 'vertical' : 'horizontal';
    $type = $type === 'multiple' ? 'multiple' : 'single';

    if ($type === 'multiple') {
        $selectedMultiple = is_array($default) ? array_values($default) : ($default !== null && $default !== '' ? [$default] : []);
        $selectedSingle = null;
    } else {
        $selectedMultiple = [];
        $selectedSingle = is_array($default) ? ($default[0] ?? null) : $default;
    }

    $gapRem = $spacing * 0.25;
@endphp

<div
    x-data="{
        type: @js($type),
        selectedSingle: @js($selectedSingle),
        selectedMultiple: @js($selectedMultiple),
        toggleValue(v) {
            if (this.type === 'multiple') {
                if (this.selectedMultiple.includes(v)) {
                    this.selectedMultiple = this.selectedMultiple.filter((x) => x !== v);
                } else {
                    this.selectedMultiple = [...this.selectedMultiple, v];
                }
            } else {
                this.selectedSingle = this.selectedSingle === v ? null : v;
            }
        },
        isOn(v) {
            return this.type === 'multiple'
                ? this.selectedMultiple.includes(v)
                : this.selectedSingle === v;
        },
    }"
    data-slot="toggle-group"
    data-variant="{{ $variant }}"
    data-size="{{ $size }}"
    data-spacing="{{ $spacing }}"
    data-orientation="{{ $orientation }}"
    @if ($orientation === 'horizontal')
        data-horizontal
    @else
        data-vertical
    @endif
    style="--toggle-group-gap: {{ $gapRem }}rem;"
    {{ $attributes->class(cn(
        'group/toggle-group flex w-fit flex-row items-center gap-[length:var(--toggle-group-gap,0px)] rounded-lg',
        'data-[size=sm]:rounded-[min(var(--radius-md),10px)]',
        'data-vertical:flex-col data-vertical:items-stretch',
    )) }}
>
    {{ $slot }}
</div>
