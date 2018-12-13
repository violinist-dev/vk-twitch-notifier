<?php

declare(strict_types=1);

namespace App\Dto;

use App\Constraint\ValidVkCommunitySenderId;
use App\Enum\VkCallbackRequestType;
use Symfony\Component\Validator\Constraints as Assert;

class ConfirmationRequest
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
     * @Assert\EqualTo(VkCallbackRequestType::CONFIRMATION)
     *
     * @var string
     */
    public $type;
}
