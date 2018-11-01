<?php

declare(strict_types=1);

namespace App\ValueObject;

interface ChannelIdentifierInterface
{
    public function getRawValue(): string;
}
