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
        return array_map(function (VkUser $vkUser) {
            return new Subscriber($vkUser);
        }, $vkUsers);
    }
}
