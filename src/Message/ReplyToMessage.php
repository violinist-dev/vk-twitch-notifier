<?php

declare(strict_types=1);

namespace App\Message;

use App\ValueObject\UserMessage\UserMessageInterface;

class ReplyToMessage
{
    /**
     * @var UserMessageInterface
     */
    private $message;

    public function __construct(UserMessageInterface $message)
    {
        $this->message = $message;
    }

    public function getMessage(): UserMessageInterface
    {
        return $this->message;
    }
}
