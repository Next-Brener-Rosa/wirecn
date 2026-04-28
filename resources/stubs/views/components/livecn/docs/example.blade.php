@props([
    'title' => null,
    'description' => null,
])

<div {{ $attributes->class('mb-12 scroll-mt-28 space-y-4') }}>
    @if ($title)
        <h3 class="font-semibold text-foreground text-xl tracking-tight">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="text-base text-muted-foreground leading-relaxed">{{ $description }}</p>
    @endif

    <div
        class="rounded-xl border border-border bg-muted/20 shadow-sm"
        data-slot="docs-preview"
    >
        <div class="flex min-h-[100px] flex-wrap items-center gap-4 p-6 sm:p-8">
            {{ $preview }}
        </div>
    </div>

    @isset($code)
        <div
            class="relative rounded-xl border border-border bg-zinc-950 text-zinc-50 dark:bg-zinc-950"
            x-data="{
                copied: false,
                copy() {
                    navigator.clipboard.writeText(this.$refs.snip.innerText);
                    this.copied = true;
                    setTimeout(() => (this.copied = false), 2000);
                },
            }"
        >
            <button
                class="absolute top-2 right-2 z-10 rounded-md border border-white/10 bg-white/5 px-2 py-1 font-medium text-xs text-zinc-200 hover:bg-white/10"
                type="button"
                x-on:click="copy()"
            >
                <span x-show="! copied">Copiar</span>
                <span x-cloak x-show="copied">Copiado</span>
            </button>
            <pre class="max-h-[min(70vh,480px)] overflow-x-auto overflow-y-auto p-4 pt-10 text-xs leading-relaxed"><code class="block whitespace-pre font-mono text-zinc-100" x-ref="snip">{{ trim((string) $code) }}</code></pre>
        </div>
    @endisset
</div>
