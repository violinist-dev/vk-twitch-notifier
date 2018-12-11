<?php

declare(strict_types=1);

namespace App\ValueObject\UserMessage;

use App\ValueObject\VkUser;

interface UserMessageInterface
{
    public static function isTextMatchesMessageType(string $text): bool;

    public function getSender(): VkUser;
}
