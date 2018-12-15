<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ReplyToMessage;
use App\Message\VkMessage;
use App\ValueObject\UserMessage\UnsubscriptionMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ReplyToUnsubscriptionMessage
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(
        MessageBusInterface $messageBus,
        TranslatorInterface $translator
    ) {
        $this->messageBus = $messageBus;
        $this->translator = $translator;
    }

    public function __invoke(ReplyToMessage $message): void
    {
        $userMessage = $message->getMessage();

        if ($userMessage instanceof UnsubscriptionMessage === false) {
            return;
        }

        $this->messageBus->dispatch(new VkMessage(
            $this->translator->trans('successful_unsubscription_command_reply', [], 'bot_messages'),
            [
                $userMessage->getSender(),
            ]
        ));
    }
}
