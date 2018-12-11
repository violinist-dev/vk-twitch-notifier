<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ReplyToMessage;
use App\Message\VkMessage;
use App\ValueObject\UserMessage\UnsubscriptionMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class ReplyToUnsubscriptionMessage
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

        if ($userMessage instanceof UnsubscriptionMessage === false) {
            return;
        }

        $this->messageBus->dispatch(
            new VkMessage(
                'Вы успешно от уведомлений. Если захотите подписаться по новой, просто отправьте сообщение с текстом «подписаться».',
                [
                    $userMessage->getSender(),
                ]
            )
        );
    }
}
