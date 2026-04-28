@props([
    'placeholder' => '',
])

<div data-slot="command-input-wrapper" class="p-1 pb-0">
    <div
        data-slot="input-group"
        class="{{ cn(
            'group/input-group flex h-8! min-w-0 w-full items-stretch overflow-hidden rounded-lg! border border-input/30 bg-input/30 text-sm shadow-none!',
            'has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-ring/40',
        ) }}"
    >
        <input
            x-model="search"
            type="text"
            autocomplete="off"
            autocapitalize="off"
            spellcheck="false"
            data-slot="command-input"
            placeholder="{{ $placeholder }}"
            {{ $attributes->class(cn(
                'min-w-0 flex-1 border-0 bg-transparent py-1 pl-2! text-sm outline-none placeholder:text-muted-foreground focus-visible:ring-0 disabled:cursor-not-allowed disabled:opacity-50',
            )) }}
        />
        <div
            class="{{ cn('flex items-stretch') }}"
            data-slot="input-group-addon"
            data-align="inline-end"
        >
            <div class="{{ cn('flex items-center pl-2! pr-2') }}">
                <x-livecn.phosphor-icon name="search" class="size-4 shrink-0 opacity-50" />
            </div>
        </div>
    </div>
</div>
