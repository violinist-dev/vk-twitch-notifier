<?php

declare(strict_types=1);

namespace App\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WorkingVkCommunityValidator extends ConstraintValidator
{
    /**
     * @var int
     */
    private $vkCommunityId;

    public function __construct(
        int $vkCommunityId
    ) {
        $this->vkCommunityId = $vkCommunityId;
    }

    /**
     * @param mixed              $value
     * @param WorkingVkCommunity $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!is_int($value)) {
            return;
        }

        if ($value !== $this->vkCommunityId) {
            $this->context->addViolation($constraint->message);

            return;
        }
    }
}
