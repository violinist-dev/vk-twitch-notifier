<?php

declare(strict_types=1);

namespace App\ValueObject;

use Symfony\Component\Validator\ConstraintViolationInterface;

interface ValidationErrorInterface
{
    /**
     * @return ConstraintViolationInterface[]
     */
    public function getConstraintViolations(): array;
}
