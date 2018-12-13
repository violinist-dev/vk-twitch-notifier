<?php

declare(strict_types=1);

namespace App\Dto;

use App\Constraint\ValidVkCommunitySenderId;
use App\Enum\VkCallbackRequestType;
use Symfony\Component\Validator\Constraints as Assert;

class MessageNewRequest
{
    /**
     * @Assert\Type("int")
     * @ValidVkCommunitySenderId()
     *
     * @var int
     */
    public $groupId;

    /**
     * @Assert\Type("integer")
     *
     * @var int
     */
    public $sender;

    /**
     * @Assert\Type("string")
     *
     * @var string
     */
    public $text;

    /**
     * @Assert\Type("string")
     * @Assert\EqualTo(VkCallbackRequestType::MESSAGE_NEW)
     *
     * @var string
     */
    public $type;
}
