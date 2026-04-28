<div data-slot="table-container" class="{{ cn('relative w-full overflow-x-auto') }}">
    <table data-slot="table" {{ $attributes->class(cn('w-full caption-bottom text-sm')) }}>
        {{ $slot }}
    </table>
</div>
