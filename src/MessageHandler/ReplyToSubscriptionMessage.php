<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ReplyToMessage;
use App\Message\VkMessage;
use App\UserSubscriber;
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

    /**
     * @var UserSubscriber
     */
    private $userSubscriber;

    public function __construct(
        MessageBusInterface $messageBus,
        TranslatorInterface $translator,
        UserSubscriber $userSubscriber
    ) {
        $this->messageBus = $messageBus;
        $this->translator = $translator;
        $this->userSubscriber = $userSubscriber;
    }

    public function __invoke(ReplyToMessage $message): void
    {
        $userMessage = $message->getMessage();

        if ($userMessage instanceof SubscriptionMessage === false) {
            return;
        }

        $this->userSubscriber->subscribe($userMessage->getSender());

        $this->messageBus->dispatch(new VkMessage(
            $this->translator->trans('successful_subscription_command_reply', [], 'bot_messages'),
            [
                $userMessage->getSender(),
            ]
        ));
    }
}
