<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\SentMessage;
use App\Message\VkMessage;
use App\Repository\SubscriberRepository;
use App\ValueObject\SentPersonalMessage;
use App\ValueObject\SentPersonalMessagePack;
use App\ValueObject\VkUser;
use App\VkClient\VkMessageSenderInterface;
use Doctrine\ORM\EntityManagerInterface;

class VkMessageSender
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SubscriberRepository
     */
    private $subscriberRepository;

    /**
     * @var VkMessageSenderInterface
     */
    private $vkMessageSender;

    public function __construct(
        EntityManagerInterface $entityManager,
        SubscriberRepository $subscriberRepository,
        VkMessageSenderInterface $vkMessageSender
    ) {
        $this->entityManager = $entityManager;
        $this->subscriberRepository = $subscriberRepository;
        $this->vkMessageSender = $vkMessageSender;
    }

    private function saveMessage(string $messageText, SentPersonalMessagePack $personalMessagePack): void
    {
        $sentMessage = new SentMessage(
            $personalMessagePack->getUniqueIdentifier(),
            $messageText,
            array_map(function (SentPersonalMessage $sentPersonalMessage): VkUser {
                return $sentPersonalMessage->getRecipient();
            }, $personalMessagePack->getMessages())
        );

        $this->entityManager->persist($sentMessage);
    }

    private function unsubscribeUnavailableUsers(SentPersonalMessagePack $personalMessagePack): void
    {
        /** VkUser[] */
        $unavailableUsers = [];

        foreach ($personalMessagePack->getMessages() as $personalMessage) {
            if ($personalMessage->getErrorMessage() === null) {
                continue;
            }

            $unavailableUsers[] = $personalMessage->getRecipient();
        }

        $subscribers = $this->subscriberRepository->getSubscribersByIds($unavailableUsers);

        foreach ($subscribers as $subscriber) {
            $this->entityManager->remove($subscriber);
        }
    }

    public function __invoke(VkMessage $vkMessage): void
    {
        $sentPersonalMessagePacks = $this->vkMessageSender->sendMessage(
            $vkMessage->getMessage(),
            $vkMessage->getRecipients()
        );

        foreach ($sentPersonalMessagePacks as $sentPersonalMessagePack) {
            $this->saveMessage($vkMessage->getMessage(), $sentPersonalMessagePack);
            $this->unsubscribeUnavailableUsers($sentPersonalMessagePack);
        }

        $this->entityManager->flush();
    }
}
