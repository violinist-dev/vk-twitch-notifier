<?php

declare(strict_types=1);

namespace App;

class VkNotifier
{
    /**
     * @var string
     */
    private $vkApiAccessToken;

    public function __construct(
        string $vkApiAccessToken
    ) {
        $this->vkApiAccessToken = $vkApiAccessToken;
    }

    public function notify(): void
    {
    }
}
