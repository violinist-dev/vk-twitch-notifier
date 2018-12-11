<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ReplyToMessage;
use App\Message\VkMessage;
use App\ValueObject\UserMessage\UnknownMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class ReplyToUnknownMessage
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(
        MessageBusInterface $messageBus
    ) {
        $this->messageBus = $messageBus;
    }

    public function __invoke(ReplyToMessage $message): void
    {
        $userMessage = $message->getMessage();

        if ($userMessage instanceof UnknownMessage === false) {
            return;
        }

        $this->messageBus->dispatch(
            new VkMessage(
                "Неопознанная команда.\n\nБот понимает только следующие команды:\n•подписаться\n•отписаться",
                [
                    $userMessage->getSender(),
                ]
            )
        );
    }
}
