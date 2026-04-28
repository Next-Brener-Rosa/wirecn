@props([
    'value' => '',
    'disabled' => false,
])

<div data-slot="accordion-item" {{ $attributes->class(cn('border-b border-border last:border-b-0')) }}>
    @isset($trigger)
        <x-livecn.accordion.trigger :value="$value" :disabled="$disabled">
            {{ $trigger }}
        </x-livecn.accordion.trigger>
    @endisset

    @isset($content)
        <x-livecn.accordion.content :value="$value">
            {{ $content }}
        </x-livecn.accordion.content>
    @endisset
</div>
