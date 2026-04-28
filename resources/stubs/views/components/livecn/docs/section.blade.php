@props([
    'id',
    'title',
    'description' => null,
])

<section class="{{ cn('scroll-mt-24 border-border border-b py-14 first:pt-2 last:border-b-0') }}" id="{{ $id }}">
    <h2 class="font-bold text-3xl tracking-tight">{{ $title }}</h2>

    @if ($description)
        <p class="mt-3 text-lg text-muted-foreground leading-relaxed">{{ $description }}</p>
    @endif

    <div class="mt-8 space-y-10">
        {{ $slot }}
    </div>
</section>
