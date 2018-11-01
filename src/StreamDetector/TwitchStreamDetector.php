<?php

declare(strict_types=1);

namespace App\StreamDetector;

use App\ValueObject\ChannelIdentifierInterface;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\Request;

class TwitchStreamDetector implements StreamDetectorInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $clientId;

    public function __construct(
        ClientInterface $client,
        string $clientId
    ) {
        $this->clientId = $clientId;
        $this->client = $client;
    }

    public function isStreamActive(ChannelIdentifierInterface $channelIdentifier): bool
    {
        $response = $this->client->request(Request::METHOD_GET, 'https://api.twitch.tv/helix/streams', [
            'headers' => [
                'Client-ID' => $this->clientId,
            ],
            'query' => [
                'user_login' => $channelIdentifier->getRawValue(),
            ],
            'http_errors' => false,
        ]);

        if ($response->getStatusCode() >= 400) {
            throw new StreamingServiceCheckFailureException();
        }

        $body = $response->getBody();

        $decodedBody = json_decode((string) $body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new StreamingServiceCheckFailureException();
        }

        return isset($decodedBody['data'][0]['viewer_count']);
    }
}
