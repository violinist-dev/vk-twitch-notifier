<?php

namespace App\Exception;

use InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolationInterface;

class DeserializationFailedException extends InvalidArgumentException
{
    /**
     * @var ConstraintViolationInterface[]
     */
    private $constraintViolations;

    public function __construct(
        array $constraintViolations
    ) {
        $this->constraintViolations = $constraintViolations;

        parent::__construct('Deserialization failed');
    }

    /**
     * @return ConstraintViolationInterface[]
     */
    public function getConstraintViolations(): array
    {
        return $this->constraintViolations;
    }
}
