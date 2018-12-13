<?php

declare(strict_types=1);

namespace App\ValueObject;

class IncomingVkMessage
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var VkUser
     */
    private $sender;

    public function __construct(
        VkUser $sender,
        string $message
    ) {
        $this->sender = $sender;
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSender(): VkUser
    {
        return $this->sender;
    }
}
