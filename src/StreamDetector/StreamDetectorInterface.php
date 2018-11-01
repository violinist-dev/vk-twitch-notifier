<?php

declare(strict_types=1);

namespace App\StreamDetector;

use App\ValueObject\ChannelIdentifierInterface;

interface StreamDetectorInterface
{
    /**
     * @throws StreamingServiceCheckFailureException
     */
    public function isStreamActive(ChannelIdentifierInterface $channelIdentifier): bool;
}
