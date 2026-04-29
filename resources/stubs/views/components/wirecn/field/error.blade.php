@props([
    'errors' => null,
])

@php
    $uniqueMessages = [];

    if (is_iterable($errors) && ! ($errors instanceof \Illuminate\Contracts\Support\MessageBag)) {
        foreach ($errors as $error) {
            $message = null;
            if (is_string($error)) {
                $message = $error;
            } elseif (is_array($error)) {
                $message = $error['message'] ?? null;
            } elseif (is_object($error) && isset($error->message)) {
                $message = $error->message;
            }
            if ($message !== null && $message !== '') {
                $uniqueMessages[$message] = $message;
            }
        }
    }

    $uniqueMessages = array_values($uniqueMessages);
@endphp

@if ($slot->isNotEmpty())
    <div
        role="alert"
        data-slot="field-error"
        {{ $attributes->class(cn('text-sm font-normal text-destructive')) }}
    >
        {{ $slot }}
    </div>
@elseif (count($uniqueMessages) === 1)
    <div
        role="alert"
        data-slot="field-error"
        {{ $attributes->class(cn('text-sm font-normal text-destructive')) }}
    >
        {{ $uniqueMessages[0] }}
    </div>
@elseif (count($uniqueMessages) > 1)
    <div
        role="alert"
        data-slot="field-error"
        {{ $attributes->class(cn('text-sm font-normal text-destructive')) }}
    >
        <ul class="{{ cn('ml-4 flex list-disc flex-col gap-1') }}">
            @foreach ($uniqueMessages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
