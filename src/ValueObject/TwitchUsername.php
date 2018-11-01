<?php

declare(strict_types=1);

namespace App\ValueObject;

class TwitchUsername implements ChannelIdentifierInterface
{
    /**
     * @var string
     */
    private $username;

    // TODO: Add self-validation
    public function __construct(
        string $username
    ) {
        $this->username = $username;
    }

    public function getRawValue(): string
    {
        return $this->getUsername();
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
