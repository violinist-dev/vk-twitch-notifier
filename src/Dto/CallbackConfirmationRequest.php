<?php

declare(strict_types=1);

namespace App\Dto;

use App\Constraint\ValidVkCommunitySenderId;
use Symfony\Component\Validator\Constraints as Assert;

class CallbackConfirmationRequest
{
    /**
     * @Assert\Type("int")
     * @ValidVkCommunitySenderId()
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
