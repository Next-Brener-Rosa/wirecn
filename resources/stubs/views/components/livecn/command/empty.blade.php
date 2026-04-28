<div
    data-slot="command-empty"
    x-show="filtered.length === 0"
    x-cloak
    {{ $attributes->class(cn('py-6 text-center text-sm')) }}
>
    @if ($slot->isEmpty())
        {{ __('Sem resultados.') }}
    @else
        {{ $slot }}
    @endif
</div>
