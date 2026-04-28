<li
    data-slot="breadcrumb-separator"
    role="presentation"
    aria-hidden="true"
    {{ $attributes->class(cn('[&_svg]:size-3.5')) }}
>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        <x-livecn.phosphor-icon name="chevron-right" class="[[dir=rtl]_&]:scale-x-[-1]" />
    @endif
</li>
