<?php

declare(strict_types=1);

namespace App\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidVkCommunitySenderIdValidator extends ConstraintValidator
{
    /**
     * @var int
     */
    private $vkMessageSenderCommunityId;

    public function __construct(
        int $vkMessageSenderCommunityId
    ) {
        $this->vkMessageSenderCommunityId = $vkMessageSenderCommunityId;
    }

    /**
     * @param mixed                    $value
     * @param ValidVkCommunitySenderId $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!is_int($value)) {
            return;
        }

        if ($value !== $this->vkMessageSenderCommunityId) {
            $this->context->addViolation($constraint->message);

            return;
        }
    }
}
