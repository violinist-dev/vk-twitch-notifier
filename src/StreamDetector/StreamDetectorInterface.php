<?php

declare(strict_types=1);

namespace App\StreamDetector;

use App\ValueObject\ChannelIdentifierInterface;
use App\ValueObject\Url;

interface StreamDetectorInterface
{
    /**
     * @throws StreamingServiceCheckFailureException
     */
    public function getActiveStream(ChannelIdentifierInterface $channelIdentifier): ?Url;
}
