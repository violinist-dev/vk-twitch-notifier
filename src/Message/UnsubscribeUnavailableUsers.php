<?php

declare(strict_types=1);

namespace App\Message;

use App\ValueObject\VkUser;

class UnsubscribeUnavailableUsers
{
    /**
     * @var array|VkUser[]
     */
    private $users;

    /**
     * @param VkUser[] $users
     */
    public function __construct(
        array $users
    ) {
        $this->users = $users;
    }

    /**
     * @return array|VkUser[]
     */
    public function getUsers()
    {
        return $this->users;
    }
}
