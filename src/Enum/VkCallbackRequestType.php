<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

class VkCallbackRequestType extends Enum
{
    public const CONFIRMATION = 'confirmation';

    public const MESSAGE_NEW = 'message_new';
}
