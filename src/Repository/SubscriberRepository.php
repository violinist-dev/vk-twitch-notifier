<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Subscriber;
use App\ValueObject\VkUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SubscriberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subscriber::class);
    }

    /**
     * @param VkUser[] $vkUsers
     *
     * @return Subscriber[]
     */
    public function getSubscribersByIds(array $vkUsers): array
    {
        $qb = $this->createQueryBuilder('subscriber');

        $qb->andWhere('subscriber.vk IN (:vkIds)');
        $qb->setParameter('vkIds', array_map(function (VkUser $vkUser): int {
            return $vkUser->getId();
        }, $vkUsers));

        /** @var Subscriber[] $subscribers */
        $subscribers = $qb->getQuery()->execute();

        return $subscribers;
    }
}
