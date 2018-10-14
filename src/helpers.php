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
