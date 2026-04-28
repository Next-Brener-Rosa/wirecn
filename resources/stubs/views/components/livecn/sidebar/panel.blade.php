@props([
    'side' => 'left',
    'variant' => 'sidebar',
    'collapsible' => 'offcanvas',
])

@php
    $side = in_array($side, ['left', 'right'], true) ? $side : 'left';
    $variant = in_array($variant, ['sidebar', 'floating', 'inset'], true) ? $variant : 'sidebar';
    $collapsible = in_array($collapsible, ['offcanvas', 'icon', 'none'], true) ? $collapsible : 'offcanvas';
    $collapsibleNone = $collapsible === 'none';

    $isFloatingOrInset = in_array($variant, ['floating', 'inset'], true);

    $gapIconWidth = $isFloatingOrInset
        ? 'group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+1rem+2px)]'
        : 'group-data-[collapsible=icon]:w-[var(--sidebar-width-icon)]';

    $containerFloating = $isFloatingOrInset
        ? 'p-2 group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+1rem+2px)]'
        : 'group-data-[collapsible=icon]:w-[var(--sidebar-width-icon)] group-data-[side=left]:border-r group-data-[side=left]:border-sidebar-border group-data-[side=right]:border-l group-data-[side=right]:border-sidebar-border';
@endphp

@if ($collapsibleNone)
    <div
        data-slot="sidebar"
        data-side="{{ $side }}"
        data-variant="{{ $variant }}"
        {{ $attributes->class(cn(
            'flex h-full w-[var(--sidebar-width)] flex-col bg-sidebar text-sidebar-foreground',
        )) }}
    >
        {{ $slot }}
    </div>
@else
    <template x-teleport="body">
        <div
            class="md:hidden"
            x-show="openMobile"
            x-cloak
            role="presentation"
            x-on:keydown.escape.window="openMobile && closeMobile()"
        >
            <div
                x-show="openMobile"
                x-transition.opacity.duration.150ms
                aria-hidden="true"
                class="fixed inset-0 z-50 bg-black/10 supports-[backdrop-filter]:backdrop-blur-xs"
                x-on:click="closeMobile()"
            ></div>
            <div
                x-trap="openMobile"
                x-show="openMobile"
                x-transition:enter="transition duration-200 ease-in-out"
                x-transition:enter-start="{{ $side === 'left' ? '-translate-x-10 opacity-0' : 'translate-x-10 opacity-0' }}"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition duration-200 ease-in-out"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="{{ $side === 'left' ? '-translate-x-10 opacity-0' : 'translate-x-10 opacity-0' }}"
                data-sidebar="sidebar"
                data-slot="sidebar"
                data-mobile="true"
                data-side="{{ $side }}"
                style="--sidebar-width: 18rem;"
                role="dialog"
                aria-modal="true"
                class="{{ cn(
                    'fixed inset-y-0 z-50 flex h-svh w-[var(--sidebar-width)] flex-col bg-sidebar p-0 text-sidebar-foreground',
                    $side === 'left' ? 'left-0 border-r border-sidebar-border' : 'right-0 border-l border-sidebar-border',
                ) }}"
            >
                <div class="sr-only">
                    <span>{{ __('Barra lateral') }}</span>
                    <span>{{ __('Navegação em ecrã pequeno.') }}</span>
                </div>
                <div class="flex h-full w-full min-h-0 flex-col">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>

    <div
        data-variant="{{ $variant }}"
        data-side="{{ $side }}"
        data-slot="sidebar"
        x-bind:data-state="open ? 'expanded' : 'collapsed'"
        x-bind:data-collapsible="open ? '' : '{{ $collapsible }}'"
        {{ $attributes->class(cn(
            'group peer hidden text-sidebar-foreground md:block',
        )) }}
    >
        <div
            data-slot="sidebar-gap"
            class="{{ cn(
                'relative w-[var(--sidebar-width)] bg-transparent transition-[width] duration-200 ease-linear',
                'group-data-[collapsible=offcanvas]:w-0',
                'group-data-[side=right]:rotate-180',
                $gapIconWidth,
            ) }}"
        ></div>
        <div
            data-slot="sidebar-container"
            data-side="{{ $side }}"
            class="{{ cn(
                'fixed inset-y-0 z-10 hidden h-svh w-[var(--sidebar-width)] transition-[left,right,width] duration-200 ease-linear md:flex',
                'data-[side=left]:left-0 data-[side=left]:group-data-[collapsible=offcanvas]:left-[calc(var(--sidebar-width)*-1)]',
                'data-[side=right]:right-0 data-[side=right]:group-data-[collapsible=offcanvas]:right-[calc(var(--sidebar-width)*-1)]',
                $containerFloating,
            ) }}"
        >
            <div
                data-sidebar="sidebar"
                data-slot="sidebar-inner"
                class="{{ cn(
                    'flex size-full min-h-0 flex-col bg-sidebar',
                    'group-data-[variant=floating]:rounded-lg group-data-[variant=floating]:shadow-sm group-data-[variant=floating]:ring-1 group-data-[variant=floating]:ring-sidebar-border',
                ) }}"
            >
                {{ $slot }}
            </div>
        </div>
    </div>
@endif
