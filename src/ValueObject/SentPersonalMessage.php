<?php

declare(strict_types=1);

namespace App\ValueObject;

use InvalidArgumentException;

class SentPersonalMessage
{
    /**
     * @var string|null
     */
    private $errorMessage;

    /**
     * @var int
     */
    private $messageId;

    /**
     * @var VkUser
     */
    private $recipient;

    public function __construct(
        VkUser $recipient,
        int $messageId,
        ?string $errorMessage
    ) {
        $this->recipient = $recipient;
        $this->messageId = $messageId;
        $this->errorMessage = $errorMessage;

        $this->validate();
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function getMessageId(): int
    {
        return $this->messageId;
    }

    public function getRecipient(): VkUser
    {
        return $this->recipient;
    }

    private function validate(): void
    {
        if ($this->messageId <= 0) {
            throw new InvalidArgumentException('messageId should be greater than 0');
        }
    }
}
