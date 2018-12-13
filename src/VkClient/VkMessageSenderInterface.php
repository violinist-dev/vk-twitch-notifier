<?php

declare(strict_types=1);

namespace App\VkClient;

use App\ValueObject\SentPersonalMessagePack;
use App\ValueObject\VkUser;

interface VkMessageSenderInterface
{
    /**
     * @param VkUser $recipients
     *
     * @return SentPersonalMessagePack[]
     */
    public function sendMessage(
        string $message,
        array $recipients
    ): array;
}
