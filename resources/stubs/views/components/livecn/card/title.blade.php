@php
    $userClass = $attributes->get('class');
@endphp

<h3
    data-slot="card-title"
    class="{{ cn(
        'cn-font-heading text-base leading-snug font-medium group-data-[size=sm]/card:text-sm',
        $userClass,
    ) }}"
    {{ $attributes->except('class') }}
>
    {{ $slot }}
</h3>
