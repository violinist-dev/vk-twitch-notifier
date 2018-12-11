<?php

declare(strict_types=1);

namespace App\ValueObject\UserMessage;

use App\ValueObject\VkUser;

class UnknownMessage implements UserMessageInterface
{
    /**
     * @var VkUser
     */
    private $sender;

    public function __construct(
        VkUser $sender
    ) {
        $this->sender = $sender;
    }

    public static function isTextMatchesMessageType(string $text): bool
    {
        return true;
    }

    public function getSender(): VkUser
    {
        return $this->sender;
    }
}
