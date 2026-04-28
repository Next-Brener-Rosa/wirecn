@php
    $userClass = $attributes->get('class');
@endphp

<div
    data-slot="card-action"
    class="{{ cn(
        'col-start-2 row-span-2 row-start-1 self-start justify-self-end',
        $userClass,
    ) }}"
    {{ $attributes->except('class') }}
>
    {{ $slot }}
</div>
