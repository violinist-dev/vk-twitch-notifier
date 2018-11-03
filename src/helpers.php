<?php

declare(strict_types=1);

namespace App;

use Traversable;

/**
 * Converts any object that implements Traversable to plain array.
 */
function traversableToArray(Traversable $traversableObject): array
{
    $array = [];

    foreach ($traversableObject as $item) {
        $array[] = $item;
    }

    return $array;
}

/**
 * Explodes string, but it string is empty returns empty array.
 *
 * @return string[]
 */
function explodeNonEmpty(string $delimiter, string $string): array
{
    if ($string === '') {
        return [];
    }

    $explodedValue = explode($delimiter, $string);

    if ($explodedValue === false) {
        return [];
    }

    return $explodedValue;
}
