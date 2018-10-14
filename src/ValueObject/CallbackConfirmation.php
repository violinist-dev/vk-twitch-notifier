<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\InvalidValueObjectException;

class CallbackConfirmation
{
    /**
     * @var int
     */
    private $groupId;

    public function __construct(
        int $groupId
    ) {
        $this->groupId = $groupId;

        $this->validate();
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    private function validate(): void
    {
        if ($this->groupId <= 0) {
            throw new InvalidValueObjectException();
        }
    }
}
