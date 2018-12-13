<?php

declare(strict_types=1);

namespace App;

/**
 * Signed negative small int value.
 *
 * @const int
 */
const NEGATIVE_SMALL_INT = -2 ** 15;

/**
 * Signed small int value.
 *
 * @const int
 */
const SMALL_INT = -NEGATIVE_SMALL_INT - 1;

/**
 * Signed negative int value.
 *
 * @const int
 */
const NEGATIVE_INT = -2 ** 31;

/**
 * Signed int value.
 *
 * @const int
 */
const INT = -NEGATIVE_INT - 1;

/**
 * Signed negative big int value.
 *
 * @const int
 */
const NEGATIVE_BIG_INT = -2 ** 63;

/**
 * Signed big int value.
 *
 * @const int
 */
const BIG_INT = -NEGATIVE_BIG_INT - 1;
