<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SubscriberRepository;
use App\ValueObject\VkUser;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=SubscriberRepository::class, readOnly=true)
 */
class Subscriber
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     *
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\Column(type="vk_user")
     *
     * @var VkUser
     */
    private $vk;

    public function __construct(
        VkUser $vk
    ) {
        $this->id = Uuid::uuid4();
        $this->vk = $vk;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getVk(): VkUser
    {
        return $this->vk;
    }
}
