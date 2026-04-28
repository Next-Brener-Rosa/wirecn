@php
    $userClass = $attributes->get('class');
@endphp

<div
    data-slot="card-description"
    class="{{ cn('text-sm text-muted-foreground', $userClass) }}"
    {{ $attributes->except('class') }}
>
    {{ $slot }}
</div>
