<?php

declare(strict_types=1);

use TailwindMerge\TailwindMerge;

if (! function_exists('cn')) {
    /**
     * Merge Tailwind classes with tailwind-merge (shadcn-style).
     *
     * @param  array<string, bool>|string|null|false  ...$inputs
     */
    function cn(string|array|null|false ...$inputs): string
    {
        $classes = [];

        foreach ($inputs as $input) {
            if ($input === null || $input === false || $input === '') {
                continue;
            }

            if (is_array($input)) {
                foreach ($input as $key => $value) {
                    if (is_string($key)) {
                        if ($value) {
                            $classes[] = $key;
                        }
                    } elseif ($value) {
                        $classes[] = $value;
                    }
                }

                continue;
            }

            $classes[] = $input;
        }

        if ($classes === []) {
            return '';
        }

        return TailwindMerge::instance()->merge(implode(' ', $classes));
    }
}
