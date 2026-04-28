@props([
    'placeholder' => '',
    'showTrigger' => true,
    'showTriggerDivider' => true,
    'showTriggerHover' => true,
    'showClear' => false,
    'invalid' => false,
])

@php
    $showTrigger = filter_var($showTrigger, FILTER_VALIDATE_BOOLEAN);
    $showTriggerDivider = filter_var($showTriggerDivider, FILTER_VALIDATE_BOOLEAN);
    $showTriggerHover = filter_var($showTriggerHover, FILTER_VALIDATE_BOOLEAN);
    $showClear = filter_var($showClear, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    data-slot="input-group"
    {{ $attributes->class(cn(
        'group/input-group flex h-8 min-w-0 w-auto max-w-full items-stretch overflow-hidden rounded-md border border-input bg-background text-sm shadow-xs transition-[color,box-shadow]',
        'has-[:focus-visible]:border-ring has-[:focus-visible]:ring-[3px] has-[:focus-visible]:ring-ring/50',
        'has-aria-invalid:border-destructive has-aria-invalid:ring-3 has-aria-invalid:ring-destructive/20',
        'dark:bg-input/30 dark:has-aria-invalid:border-destructive/50 dark:has-aria-invalid:ring-destructive/40',
    )) }}
>
    <input
        x-ref="input"
        type="text"
        role="combobox"
        autocomplete="off"
        x-model="query"
        x-bind:id="inputId"
        x-bind:disabled="disabled"
        x-bind:aria-expanded="open.toString()"
        @if ($invalid)
            aria-invalid="true"
        @endif
        aria-autocomplete="list"
        x-bind:aria-controls="listId"
        placeholder="{{ $placeholder }}"
        x-on:focus="open = true"
        x-on:click="open = true"
        class="{{ cn(
            'min-w-0 flex-1 border-0 bg-transparent px-3 py-2 outline-none placeholder:text-muted-foreground focus-visible:ring-0 disabled:cursor-not-allowed disabled:opacity-50',
        ) }}"
    />
    <div
        class="{{ cn(
            'flex items-stretch',
            $showTriggerDivider ? 'border-l border-input' : 'border-l-0',
        ) }}"
        data-align="inline-end"
    >
        @if ($showTrigger)
            <div
                class="{{ cn('flex items-stretch') }}"
                @if ($showClear)
                    x-show="query.length === 0"
                    x-cloak
                @endif
            >
                <x-livecn.combobox.trigger
                    :hoverable="$showTriggerHover"
                    class="rounded-none border-0 bg-transparent px-2 shadow-none"
                />
            </div>
        @endif
        @if ($showClear)
            <x-livecn.combobox.clear />
        @endif
    </div>
</div>
