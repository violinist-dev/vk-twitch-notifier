<?php

declare(strict_types=1);

namespace App\VkClient;

use App\ValueObject\VkUser;
use GuzzleHttp\ClientInterface;

class VkClient implements VkMessageSenderInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $vkAccessToken;

    /**
     * @var string
     */
    private $vkApiVersion;

    public function __construct(
        ClientInterface $httpClient,
        string $vkAccessToken,
        string $vkApiVersion
    ) {
        $this->httpClient = $httpClient;
        $this->vkAccessToken = $vkAccessToken;
        $this->vkApiVersion = $vkApiVersion;
    }

    /**
     * @return VkUser[]
     */
    public function sendMessage(string $message, array $recipients): array
    {
        $response = $this->httpClient->request(
            'POST',
            'https://api.vk.com/method/execute',
            [
                'json' => [
                    'accessToken' => $this->vkAccessToken,
                    'v' => $this->vkApiVersion,
                    'code' => '',
                ],
            ]
        );

        $jsonResponse = json_decode($response->getBody(), true);

        return array_map(function (int $unavailableRecipient) {
            return new VkUser($unavailableRecipient);
        }, $jsonResponse['unavailableRecipients']);
    }
}
