@props([
    'title' => 'Command Palette',
    'description' => 'Search for a command to run...',
    'showCloseButton' => false,
])

@php
    $showCloseButton = filter_var($showCloseButton, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    x-data="uiCommandDialog()"
    x-on:keydown.window="if (($event.metaKey || $event.ctrlKey) && $event.key.toLowerCase() === 'k') { $event.preventDefault(); open = !open }"
    {{ $attributes->class(cn('relative')) }}
>
    <div x-on:click="open = true">
        {{ $trigger }}
    </div>

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50"
            x-on:keydown.escape.window="close()"
            role="presentation"
        >
            <div
                class="fixed inset-0 bg-black/80"
                aria-hidden="true"
                data-testid="command-dialog-backdrop"
                x-on:click="close()"
            ></div>
            <div
                class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto p-4 pt-[min(33vh,12rem)]"
                role="presentation"
            >
                <div
                    x-trap="open"
                    x-show="open"
                    x-transition
                    x-ref="dialogContent"
                    role="dialog"
                    aria-modal="true"
                    data-slot="dialog-content"
                    data-testid="command-dialog-content"
                    x-on:click.stop
                    x-on:command-select="close()"
                    {{ $content->attributes->class(cn(
                        'relative z-50 w-full max-w-xl translate-y-0 overflow-hidden rounded-xl! border bg-background p-0 text-foreground shadow-lg duration-200',
                    )) }}
                >
                    <div class="sr-only">
                        <h2>{{ $title }}</h2>
                        <p>{{ $description }}</p>
                    </div>
                    @if ($showCloseButton)
                        <div class="absolute right-2 top-2 z-10">
                            <x-livecn.button
                                type="button"
                                variant="ghost"
                                size="icon"
                                class="size-8 rounded-md"
                                x-on:click="close()"
                                aria-label="{{ __('Fechar') }}"
                            >
                                <x-livecn.phosphor-icon name="x" class="size-4" />
                            </x-livecn.button>
                        </div>
                    @endif
                    {{ $content }}
                </div>
            </div>
        </div>
    </template>
</div>
