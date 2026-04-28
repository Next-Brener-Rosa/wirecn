@props([
    'mode' => 'single',
    'showOutsideDays' => true,
    'captionLayout' => 'label',
    'buttonVariant' => 'ghost',
    'locale' => null,
    'weekStartsOn' => 1,
    'value' => null,
    'from' => null,
    'to' => null,
    'defaultMonth' => null,
    'min' => null,
    'max' => null,
    'name' => null,
    'fromName' => null,
    'toName' => null,
])

@php
    $locale = $locale ?? config('app.locale', 'pt');
    $locale = str_replace('_', '-', $locale);

    $calendarConfig = [
        'mode' => $mode,
        'showOutsideDays' => $showOutsideDays,
        'locale' => $locale,
        'weekStartsOn' => (int) $weekStartsOn,
        'initialSelected' => $value,
        'initialFrom' => $from,
        'initialTo' => $to,
        'defaultMonth' => $defaultMonth,
        'min' => $min,
        'max' => $max,
    ];

    $navVariant = in_array($buttonVariant, ['default', 'destructive', 'outline', 'secondary', 'ghost', 'link'], true)
        ? $buttonVariant
        : 'ghost';

    $captionId = 'calendar-caption-'.Illuminate\Support\Str::random(8);
@endphp

<div
    x-data="uiCalendar(@js($calendarConfig))"
    data-slot="calendar"
    {{ $attributes->class(cn(
        'group/calendar bg-background p-2 [--cell-radius:var(--radius-md)] [--cell-size:--spacing(7)] in-data-[slot=card-content]:bg-transparent in-data-[slot=popover-content]:bg-transparent rtl:**:[.rdp-button_next>svg]:rotate-180 rtl:**:[.rdp-button_previous>svg]:rotate-180',
    )) }}
>
    @if ($name && $mode === 'single')
        <input type="hidden" name="{{ $name }}" x-bind:value="selectedIso" class="hidden" tabindex="-1" />
    @endif
    @if ($mode === 'range')
        @if ($fromName)
            <input type="hidden" name="{{ $fromName }}" x-bind:value="rangeFromIso" class="hidden" tabindex="-1" />
        @endif
        @if ($toName)
            <input type="hidden" name="{{ $toName }}" x-bind:value="rangeToIso" class="hidden" tabindex="-1" />
        @endif
    @endif

    <div class="{{ cn('relative flex w-fit flex-col gap-4 md:flex-row', 'rdp-months') }}">
        <div class="{{ cn('flex w-full flex-col gap-4', 'rdp-month') }}">
            <div
                class="{{ cn(
                    'absolute inset-x-0 top-0 flex w-full items-center justify-between gap-1',
                    'rdp-nav',
                ) }}"
            >
                <x-livecn.button
                    type="button"
                    variant="{{ $navVariant }}"
                    size="icon"
                    class="{{ cn(
                        'size-(--cell-size) p-0 select-none aria-disabled:opacity-50',
                        'rdp-button_previous',
                    ) }}"
                    x-on:click.prevent="prevMonth()"
                    aria-label="{{ __('Mês anterior') }}"
                >
                    <x-livecn.phosphor-icon name="chevron-left" class="size-4 [[dir=rtl]_&]:rotate-180" />
                </x-livecn.button>
                <x-livecn.button
                    type="button"
                    variant="{{ $navVariant }}"
                    size="icon"
                    class="{{ cn(
                        'size-(--cell-size) p-0 select-none aria-disabled:opacity-50',
                        'rdp-button_next',
                    ) }}"
                    x-on:click.prevent="nextMonth()"
                    aria-label="{{ __('Mês seguinte') }}"
                >
                    <x-livecn.phosphor-icon name="chevron-right" class="size-4 [[dir=rtl]_&]:rotate-180" />
                </x-livecn.button>
            </div>

            <div
                id="{{ $captionId }}"
                class="{{ cn(
                    'flex h-(--cell-size) w-full items-center justify-center px-(--cell-size) font-medium select-none',
                    $captionLayout === 'label' ? 'text-sm' : 'cn-calendar-caption-label flex items-center gap-1 rounded-(--cell-radius) text-sm [&_svg]:size-3.5 [&_svg]:text-muted-foreground',
                    'rdp-month_caption',
                ) }}"
                role="presentation"
                aria-live="polite"
                x-text="monthCaption()"
            ></div>

            <table class="{{ cn('w-full border-collapse', 'rdp-table') }}" role="grid" aria-labelledby="{{ $captionId }}">
                <thead class="{{ cn('flex', 'rdp-weekdays') }}">
                    <tr class="flex w-full">
                        <template x-for="(label, li) in weekdayLabels()" :key="li">
                            <th
                                class="{{ cn(
                                    'flex-1 rounded-(--cell-radius) text-[0.8rem] font-normal text-muted-foreground select-none',
                                    'rdp-weekday',
                                ) }}"
                                scope="col"
                                x-text="label"
                            ></th>
                        </template>
                    </tr>
                </thead>
                <tbody class="{{ cn('rdp-weeks') }}">
                    <template x-for="(week, wi) in buildWeeks()" :key="wi">
                        <tr class="{{ cn('mt-2 flex w-full', 'rdp-week') }}">
                            <template x-for="(cell, di) in week" :key="cell.key">
                                <td
                                    class="rdp-day"
                                    role="presentation"
                                    x-bind:class="dayTdClass(cell)"
                                    x-bind:data-selected="isSelectedSingle(cell.date) ? 'true' : null"
                                >
                                    <x-livecn.button
                                        type="button"
                                        variant="ghost"
                                        size="icon"
                                        x-bind:class="`${dayButtonClass()} rdp-day_button min-h-(--cell-size) w-full`"
                                        x-bind:data-day="cell.key"
                                        x-bind:data-selected-single="isSelectedSingle(cell.date) ? 'true' : null"
                                        x-bind:data-range-start="isRangeStart(cell.date) ? 'true' : null"
                                        x-bind:data-range-end="isRangeEnd(cell.date) ? 'true' : null"
                                        x-bind:data-range-middle="isRangeMiddle(cell.date) ? 'true' : null"
                                        x-bind:disabled="isDisabled(cell.date)"
                                        x-show="!cell.hide"
                                        x-on:click.prevent="selectDay(cell)"
                                        x-text="cell.dayNum"
                                    ></x-livecn.button>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
