<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UnsubscribeUnavailableUsers;
use App\Repository\SubscriberRepository;
use Doctrine\ORM\EntityManagerInterface;

class UnavailableUsersUnsubscriber
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SubscriberRepository
     */
    private $subscriberRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SubscriberRepository $subscriberRepository
    ) {
        $this->entityManager = $entityManager;
        $this->subscriberRepository = $subscriberRepository;
    }

    public function __invoke(UnsubscribeUnavailableUsers $message): void
    {
        $subscribers = $this->subscriberRepository->getSubscribersByIds($message->getUsers());

        foreach ($subscribers as $subscriber) {
            $this->entityManager->remove($subscriber);
        }

        $this->entityManager->flush();
    }
}
