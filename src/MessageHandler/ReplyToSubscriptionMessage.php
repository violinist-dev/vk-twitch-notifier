<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ReplyToMessage;
use App\Message\VkMessage;
use App\ValueObject\UserMessage\SubscriptionMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ReplyToSubscriptionMessage
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

        if ($userMessage instanceof SubscriptionMessage === false) {
            return;
        }

        $this->messageBus->dispatch(new VkMessage(
            $this->translator->trans('successful_subscription_command_reply', [], 'bot_messages'),
            [
                $userMessage->getSender(),
            ]
        ));
    }
}
