<?php

declare(strict_types=1);

namespace App\Message;

use App\ValueObject\VkUser;

class VkMessage
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var VkUser[]
     */
    private $recipients;

    /**
     * @param VkUser[] $recipients
     */
    public function __construct(
        string $message,
        array $recipients
    ) {
        $this->message = $message;
        $this->recipients = $recipients;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return VkUser[]
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
