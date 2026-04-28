@php
    $titleId = $attributes->get('id') ?? 'alert-dlg-title-'.Illuminate\Support\Str::random(8);
@endphp

<h2
    id="{{ $titleId }}"
    data-slot="alert-dialog-title"
    {{ $attributes->except('id')->class(cn(
        'text-base font-medium tracking-tight',
        'sm:group-data-[size=default]/alert-dialog-content:group-has-data-[slot=alert-dialog-media]/alert-dialog-content:col-start-2',
    )) }}
>
    {{ $slot }}
</h2>
