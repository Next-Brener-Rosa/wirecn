{{--
    Toaster estilo Sonner: incluir uma vez no layout (ex. após <body>).
    JS: toast.success('…'), toast.warning, toast.error, toast.info, toast.loading; toast.dismiss(id).
    Livewire: $this->dispatch('wirecn-toast', type: 'success', message: '…', description: null, duration: 4000);
    Evento: window.dispatchEvent(new CustomEvent('wirecn-toast', { detail: { type: 'error', message: '…' } }));
--}}
@props([
    'position' => 'bottom-right',
])

@php
    $position = is_string($position) ? $position : 'bottom-right';
    $positionKey = str_replace('_', '-', \Illuminate\Support\Str::lower($position));

    $positionClasses = match ($positionKey) {
        'bottom-left' => 'bottom-4 left-4 items-start',
        'top-right' => 'top-4 right-4 items-end',
        'top-left' => 'top-4 left-4 items-start',
        default => 'bottom-4 right-4 items-end',
    };
@endphp

<div
    x-data
    data-slot="toaster"
    aria-live="polite"
    role="region"
    aria-label="Notifications"
    style="
        --normal-bg: var(--popover);
        --normal-text: var(--popover-foreground);
        --normal-border: var(--border);
        --border-radius: var(--radius);
    "
    {{ $attributes->class(cn(
        'pointer-events-none fixed z-[200] flex w-[min(100vw-2rem,22rem)] flex-col gap-2',
        $positionClasses,
    )) }}
>
    <template x-for="t in $store.wirecnToast.items" :key="t.id">
        <div
            class="pointer-events-auto flex w-full gap-3 rounded-[var(--border-radius)] border border-[var(--normal-border)] bg-[var(--normal-bg)] px-3 py-2.5 text-sm text-[var(--normal-text)] shadow-md ring-1 ring-foreground/10 dark:ring-border/60"
            data-slot="toast"
            role="status"
            x-bind:data-variant="t.variant"
        >
            <span class="mt-0.5 shrink-0 [&_svg]:size-4 [&_svg]:shrink-0" aria-hidden="true">
                {{-- success --}}
                <svg
                    x-show="t.variant === 'success'"
                    x-cloak
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="text-emerald-600 dark:text-emerald-400"
                >
                    <circle cx="12" cy="12" r="10" />
                    <path d="m9 12 2 2 4-4" />
                </svg>
                {{-- info --}}
                <svg
                    x-show="t.variant === 'info'"
                    x-cloak
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="text-sky-600 dark:text-sky-400"
                >
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 16v-4" />
                    <path d="M12 8h.01" />
                </svg>
                {{-- warning --}}
                <svg
                    x-show="t.variant === 'warning'"
                    x-cloak
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="text-amber-600 dark:text-amber-500"
                >
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
                {{-- error --}}
                <svg
                    x-show="t.variant === 'error'"
                    x-cloak
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="text-destructive"
                >
                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2" />
                    <path d="m15 9-6 6" />
                    <path d="m9 9 6 6" />
                </svg>
                {{-- loading --}}
                <svg
                    x-show="t.variant === 'loading'"
                    x-cloak
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="animate-spin text-muted-foreground"
                >
                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                </svg>
                {{-- default / fallback --}}
                <svg
                    x-show="t.variant !== 'success' && t.variant !== 'info' && t.variant !== 'warning' && t.variant !== 'error' && t.variant !== 'loading'"
                    x-cloak
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="text-muted-foreground"
                >
                    <circle cx="12" cy="12" r="10" />
                </svg>
            </span>
            <div class="min-w-0 flex-1 space-y-0.5 pt-0.5">
                <p class="font-medium leading-none" x-text="t.title"></p>
                <p
                    class="text-muted-foreground text-sm leading-snug"
                    x-show="t.description && t.description.length"
                    x-text="t.description"
                    x-cloak
                ></p>
            </div>
            <button
                type="button"
                class="-m-1 shrink-0 rounded-md p-1 text-muted-foreground opacity-70 transition-opacity hover:opacity-100 focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                data-slot="toast-close"
                aria-label="Close"
                x-on:click="$store.wirecnToast.dismiss(t.id)"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-4" aria-hidden="true">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>
