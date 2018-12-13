<?php

declare(strict_types=1);

namespace App;

use App\ValueObject\Url;
use GuzzleHttp\ClientInterface;

class VkNotifier
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $vkMessageSenderAccessToken;

    /**
     * @var string
     */
    private $vkMessageSenderCommunityId;

    public function __construct(
        ClientInterface $client,
        string $vkMessageSenderAccessToken,
        int $vkMessageSenderCommunityId
    ) {
        $this->client = $client;
        $this->vkMessageSenderAccessToken = $vkMessageSenderAccessToken;
        $this->vkMessageSenderCommunityId = $vkMessageSenderCommunityId;
    }

    /**
     * @param Url[] $activeStreams
     */
    public function notify(array $activeStreams): void
    {
    }
}
