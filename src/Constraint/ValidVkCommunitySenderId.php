<?php

declare(strict_types=1);

namespace App\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidVkCommunitySenderId extends Constraint
{
    /**
     * @var string
     */
    public $message = 'This VK community is not supported by the service.';
}
