<?php

declare(strict_types=1);

namespace App\ValueObject\UserMessage;

use App\ValueObject\VkUser;

class SubscriptionMessage implements UserMessageInterface
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
        $loweredText = mb_strtolower($text);

        return in_array($loweredText, [
            // RU
            'подписаться',
            'подписатся',
            'подписка',

            // EN
            'sub',
            'subscribe',
        ], true);
    }

    public function getSender(): VkUser
    {
        return $this->sender;
    }
}
