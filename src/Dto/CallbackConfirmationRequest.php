<?php

declare(strict_types=1);

namespace App\Dto;

use App\Constraint\WorkingVkCommunity;
use Symfony\Component\Validator\Constraints as Assert;

class CallbackConfirmationRequest
{
    /**
     * @Assert\Type("int")
     * @WorkingVkCommunity()
     *
     * @var int
     */
    public $groupId;

    /**
     * @Assert\Type("string")
     * @Assert\EqualTo("confirmation")
     *
     * @var string
     */
    public $type;
}
