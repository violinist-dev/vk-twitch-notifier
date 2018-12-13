<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SentMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SentMessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SentMessage::class);
    }

    public function getNextMessageIdentifier(): int
    {
        $qb = $this->createQueryBuilder('sent_message');

        $qb->select('MAX(sent_message.id) AS lastId');

        $lastId = $qb->getQuery()->getSingleScalarResult();

        if ($lastId === null) {
            return 1;
        }

        return $lastId + 1;
    }
}
