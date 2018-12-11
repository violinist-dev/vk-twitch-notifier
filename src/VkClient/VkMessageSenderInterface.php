<?php

declare(strict_types=1);

namespace App\VkClient;

use App\ValueObject\VkUser;

interface VkMessageSenderInterface
{
    /**
     * @param VkUser $recipients
     *
     * @return VkUser[]
     */
    public function sendMessage(
        string $message,
        array $recipients
    ): array;
}
