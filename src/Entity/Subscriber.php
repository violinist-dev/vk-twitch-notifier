<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\VkUser;

class Subscriber
{
    private $id;

    /**
     * @var VkUser
     */
    private $vk;

    public function __construct(
        VkUser $vk
    ) {
        $this->vk = $vk;
    }

    /**
     * @return VkUser
     */
    public function getVk(): VkUser
    {
        return $this->vk;
    }
}
