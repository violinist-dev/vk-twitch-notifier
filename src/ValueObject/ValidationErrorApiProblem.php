<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Enum\ApiProblemType;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ValidationErrorApiProblem extends ApiProblem implements ValidationErrorInterface
{
    /**
     * @var ConstraintViolationInterface[]
     */
    private $constraintViolations;

    /**
     * @param ConstraintViolationInterface[] $constraintViolations
     */
    public function __construct(
        int $status,
        ApiProblemType $type,
        string $title,
        string $detail,
        ?string $instance,
        array $constraintViolations
    ) {
        parent::__construct($status, $type, $title, $detail, $instance);

        $this->constraintViolations = $constraintViolations;
    }

    /**
     * @return ConstraintViolationInterface[]
     */
    public function getConstraintViolations(): array
    {
        return $this->constraintViolations;
    }
}
