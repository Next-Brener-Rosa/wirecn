@php
    $userClass = $attributes->get('class');
@endphp

<div
    data-slot="card-footer"
    class="{{ cn(
        'flex items-center rounded-b-xl border-t bg-muted/50 p-4 group-data-[size=sm]/card:p-3',
        $userClass,
    ) }}"
    {{ $attributes->except('class') }}
>
    {{ $slot }}
</div>
