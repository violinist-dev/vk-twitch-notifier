<?php

namespace App\ValueObject;

use Symfony\Component\Validator\ConstraintViolationInterface;

interface ValidationErrorInterface
{
    /**
     * @return ConstraintViolationInterface[]
     */
    public function getConstraintViolations(): array;
}
