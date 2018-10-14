<?php

namespace App\Dto;

use App\Constraint\WorkingVkCommunity;
use Symfony\Component\Validator\Constraints as Assert;

class CallbackConfirmationRequest
{
    /**
     * @Assert\Type("string")
     * @Assert\EqualTo("confirmation")
     *
     * @var string
     */
    public $type;

    /**
     * @Assert\Type("int")
     * @WorkingVkCommunity()
     *
     * @var int
     */
    public $groupId;
}
