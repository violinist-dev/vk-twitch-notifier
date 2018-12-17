<?php

declare(strict_types=1);

namespace App;

use App\Entity\Subscriber;
use App\Repository\SubscriberRepository;
use App\ValueObject\VkUser;
use Doctrine\ORM\EntityManagerInterface;

class UserSubscriber
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

    public function subscribe(VkUser $user): void
    {
        $subscribers = $this->subscriberRepository->getSubscribersByIds([$user]);

        if (count($subscribers) !== 0) {
            return;
        }

        $subscriber = new Subscriber($user);

        $this->entityManager->persist($subscriber);
        $this->entityManager->flush();
    }

    public function unsubscribe(VkUser $user): void
    {
        $subscribers = $this->subscriberRepository->getSubscribersByIds([$user]);

        if (count($subscribers) === 0) {
            return;
        }

        $this->entityManager->remove($subscribers[0]);
        $this->entityManager->flush();
    }
}
