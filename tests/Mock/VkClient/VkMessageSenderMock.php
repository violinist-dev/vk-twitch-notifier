<?php

declare(strict_types=1);

namespace App\Tests\Mock\VkClient;

use App\Repository\SentMessageRepository;
use App\ValueObject\SentPersonalMessage;
use App\ValueObject\SentPersonalMessagePack;
use App\ValueObject\VkUser;
use App\VkClient\VkMessageSenderInterface;
use const App\INT;

class VkMessageSenderMock implements VkMessageSenderInterface
{
    /**
     * @var SentMessageRepository
     */
    private $sentMessageRepository;

    public function __construct(
        SentMessageRepository $sentMessageRepository
    ) {
        $this->sentMessageRepository = $sentMessageRepository;
    }

    /**
     * @param VkUser $recipients
     *
     * @return SentPersonalMessagePack[]
     */
    public function sendMessage(string $message, array $recipients): array
    {
        $personalMessages = array_map(function (VkUser $recipient): SentPersonalMessage {
            return new SentPersonalMessage(
                $recipient,
                mt_rand(1, INT),
                null
            );
        }, $recipients);

        return [
            new SentPersonalMessagePack(
                $this->sentMessageRepository->getNextMessageIdentifier(),
                $personalMessages
            ),
        ];
    }
}
