<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ReplyToMessage;
use App\Message\VkMessage;
use App\ValueObject\UserMessage\SubscriptionMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class ReplyToSubscriptionMessage
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

        if ($userMessage instanceof SubscriptionMessage === false) {
            return;
        }

        $this->messageBus->dispatch(
            new VkMessage(
                "Вы успешно подписались на уведомления. Вы будете получать уведомления о стримах на всех площадках, на которых зарегистрирован стример, в течение 5 минут со старта трансляции.\n\nОбратите внимание: если вы запретите боту присылать вам сообщения, то будете автоматически исключены из рассылки уведомлений.\n\nЕсли вдруг захотите отписаться, просто отправьте сообщение с текстом «отписаться».",
                [
                    $userMessage->getSender(),
                ]
            )
        );
    }
}
