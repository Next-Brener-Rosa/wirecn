@php
    $descId = $attributes->get('id') ?? 'alert-dlg-desc-'.Illuminate\Support\Str::random(8);
@endphp

<div
    id="{{ $descId }}"
    data-slot="alert-dialog-description"
    {{ $attributes->except('id')->class(cn(
        'text-sm text-balance text-muted-foreground md:text-pretty',
        '[&_a]:underline [&_a]:underline-offset-[3px] [&_a]:hover:text-foreground',
    )) }}
>
    {{ $slot }}
</div>
