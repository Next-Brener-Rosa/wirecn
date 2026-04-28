@props([
    'value' => '',
])

@php
    $idBase = \Illuminate\Support\Str::slug($value);
    $tabId = 'tab-'.$idBase;
    $panelId = 'tabpanel-'.$idBase;
    $valueJson = json_encode($value, JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
@endphp

<button
    type="button"
    role="tab"
    id="{{ $tabId }}"
    data-slot="tabs-trigger"
    data-tab="{{ $value }}"
    x-bind:tabindex="active === {{ $valueJson }} ? 0 : -1"
    x-bind:aria-selected="(active === {{ $valueJson }}).toString()"
    aria-controls="{{ $panelId }}"
    x-bind:data-active="active === {{ $valueJson }} ? '' : null"
    x-on:click="select({{ $valueJson }})"
    x-on:keydown="focusFromKeyboard($event)"
    {{ $attributes->class(cn(
        'relative inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 rounded-md border border-transparent px-1.5 py-0.5 text-sm font-medium whitespace-nowrap text-foreground/60 transition-all',
        'group-data-vertical/tabs:w-full group-data-vertical/tabs:justify-start',
        'hover:text-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:outline-1 focus-visible:outline-ring',
        'disabled:pointer-events-none disabled:opacity-50 has-data-[icon=inline-end]:pr-1 has-data-[icon=inline-start]:pl-1',
        'aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-muted-foreground dark:hover:text-foreground',
        'group-data-[variant=default]/tabs-list:data-active:shadow-sm group-data-[variant=line]/tabs-list:data-active:shadow-none',
        '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4',
        'group-data-[variant=line]/tabs-list:bg-transparent group-data-[variant=line]/tabs-list:data-active:bg-transparent',
        'dark:group-data-[variant=line]/tabs-list:data-active:border-transparent dark:group-data-[variant=line]/tabs-list:data-active:bg-transparent',
        'data-active:bg-background data-active:text-foreground dark:data-active:border-input dark:data-active:bg-input/30 dark:data-active:text-foreground',
        'after:absolute after:bg-foreground after:opacity-0 after:transition-opacity',
        'group-data-horizontal/tabs:after:inset-x-0 group-data-horizontal/tabs:after:bottom-[-5px] group-data-horizontal/tabs:after:h-0.5',
        'group-data-vertical/tabs:after:inset-y-0 group-data-vertical/tabs:after:-right-1 group-data-vertical/tabs:after:w-0.5',
        'group-data-[variant=line]/tabs-list:data-active:after:opacity-100',
    )) }}
>
    {{ $slot }}
</button>
