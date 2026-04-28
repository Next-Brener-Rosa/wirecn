<?php

declare(strict_types=1);

namespace Livecn\Laravel\Support;

/**
 * Tamanhos por variante alinhados ao Flux UI (outline/solid 24px, mini 20px, micro 16px).
 *
 * @see https://fluxui.dev/components/icon
 */
final class UiIcon
{
    /**
     * @param  non-empty-string|null  $variant  outline|solid|mini|micro, ou null para o tamanho de recurso do ícone
     * @param  non-empty-string  $fallback  quando $variant é null (retrocompatível)
     */
    public static function sizeForVariant(?string $variant, string $fallback = 'size-4'): string
    {
        if ($variant === null || $variant === '') {
            return $fallback;
        }

        return match ($variant) {
            'outline', 'solid' => 'size-6',
            'mini' => 'size-5',
            'micro' => 'size-4',
            default => $fallback,
        };
    }
}
