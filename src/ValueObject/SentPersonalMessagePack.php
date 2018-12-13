<?php

declare(strict_types=1);

namespace App\ValueObject;

use InvalidArgumentException;

class SentPersonalMessagePack
{
    /**
     * @var SentPersonalMessage[]
     */
    private $messages;

    /**
     * @var int
     */
    private $uniqueIdentifier;

    /**
     * @param SentPersonalMessage[] $messages
     */
    public function __construct(
        int $uniqueIdentifier,
        array $messages
    ) {
        $this->uniqueIdentifier = $uniqueIdentifier;
        $this->messages = $messages;

        $this->validate();
    }

    /**
     * @return SentPersonalMessage[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getUniqueIdentifier(): int
    {
        return $this->uniqueIdentifier;
    }

    private function validate(): void
    {
        if ($this->uniqueIdentifier <= 0) {
            throw new InvalidArgumentException('uniqueIdentifier should be greater than 0');
        }

        if (count($this->messages) === 0) {
            throw new InvalidArgumentException('messages array should have at least 1 item');
        }
    }
}
