<?php

declare(strict_types=1);

namespace App;

use App\ValueObject\UserMessage\SubscriptionMessage;
use App\ValueObject\UserMessage\UnknownMessage;
use App\ValueObject\UserMessage\UnsubscriptionMessage;
use App\ValueObject\UserMessage\UserMessageInterface;
use App\ValueObject\VkUser;

class UserMessageTypeDetector
{
    public function detectType(string $text, VkUser $sender): UserMessageInterface
    {
        if (SubscriptionMessage::isTextMatchesMessageType($text) === true) {
            return new SubscriptionMessage($sender);
        }

        if (UnsubscriptionMessage::isTextMatchesMessageType($text) === true) {
            return new UnsubscriptionMessage($sender);
        }

        return new UnknownMessage($sender);
    }
}
