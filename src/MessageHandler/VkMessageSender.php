<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\VkMessage;
use App\VkClient\VkMessageSenderInterface;

class VkMessageSender
{
    /**
     * @var VkMessageSenderInterface
     */
    private $vkMessageSender;

    public function __construct(
        VkMessageSenderInterface $vkMessageSender
    ) {
        $this->vkMessageSender = $vkMessageSender;
    }

    public function __invoke(VkMessage $vkMessage): void
    {
        $this->vkMessageSender->sendMessage(
            $vkMessage->getMessage(),
            $vkMessage->getRecipients()
        );
    }
}
