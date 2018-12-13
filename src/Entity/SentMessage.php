<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SentMessageRepository;
use App\ValueObject\VkUser;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SentMessageRepository::class, readOnly=true)
 */
class SentMessage
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="bigint")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $message;

    /**
     * @ORM\Column(type="vk_user_collection")
     *
     * @var VkUser[]
     */
    private $recipients;

    public function __construct(
        int $id,
        string $message,
        array $recipients
    ) {
        $this->id = $id;
        $this->message = $message;
        $this->recipients = $recipients;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return VkUser[]
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
