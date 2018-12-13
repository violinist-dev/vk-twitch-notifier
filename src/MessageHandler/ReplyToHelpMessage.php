<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ReplyToMessage;
use App\Message\VkMessage;
use App\ValueObject\UserMessage\HelpMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class ReplyToHelpMessage
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

        if ($userMessage instanceof HelpMessage === false) {
            return;
        }

        $this->messageBus->dispatch(
            new VkMessage(
                "Чтобы ответить боту, надо отправить сообщение со словом-командой. Бот понимает следующие команды:\n•подписаться\n•отписаться\n•команды\n\nСообщения, которые вы отправляете боту, не читают живые люди. Если вам надо с кем-то связаться, то вам следует обратиться к кому-нибудь, кто указан в качестве контактного лица в официальной группе стримера.",
                [
                    $userMessage->getSender(),
                ]
            )
        );
    }
}
