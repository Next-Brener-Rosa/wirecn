@php
    $userClass = $attributes->get('class');
@endphp

<div
    data-slot="card-content"
    class="{{ cn('px-4 group-data-[size=sm]/card:px-3', $userClass) }}"
    {{ $attributes->except('class') }}
>
    {{ $slot }}
</div>
