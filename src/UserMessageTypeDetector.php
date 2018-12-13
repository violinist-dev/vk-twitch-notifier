<?php

declare(strict_types=1);

namespace App;

use App\ValueObject\IncomingVkMessage;
use App\ValueObject\UserMessage\HelpMessage;
use App\ValueObject\UserMessage\SubscriptionMessage;
use App\ValueObject\UserMessage\UnknownMessage;
use App\ValueObject\UserMessage\UnsubscriptionMessage;
use App\ValueObject\UserMessage\UserMessageInterface;

class UserMessageTypeDetector
{
    public function detectType(IncomingVkMessage $incomingMessage): UserMessageInterface
    {
        if (SubscriptionMessage::isTextMatchesMessageType($incomingMessage->getMessage()) === true) {
            return new SubscriptionMessage($incomingMessage->getSender());
        }

        if (UnsubscriptionMessage::isTextMatchesMessageType($incomingMessage->getMessage()) === true) {
            return new UnsubscriptionMessage($incomingMessage->getSender());
        }

        if (HelpMessage::isTextMatchesMessageType($incomingMessage->getMessage()) === true) {
            return new HelpMessage($incomingMessage->getSender());
        }

        return new UnknownMessage($incomingMessage->getSender());
    }
}
