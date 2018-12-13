<?php

declare(strict_types=1);

namespace App\VkClient;

use App\Repository\SentMessageRepository;
use App\ValueObject\SentPersonalMessage;
use App\ValueObject\SentPersonalMessagePack;
use App\ValueObject\VkUser;
use GuzzleHttp\ClientInterface;

class VkClient implements VkMessageSenderInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var SentMessageRepository
     */
    private $sentMessageRepository;

    /**
     * @var string
     */
    private $vkAccessToken;

    /**
     * @var string
     */
    private $vkApiVersion;

    /**
     * @var string
     */
    private $vkScriptsDir;

    public function __construct(
        ClientInterface $httpClient,
        SentMessageRepository $sentMessageRepository,
        string $vkAccessToken,
        string $vkApiVersion,
        string $vkScriptsDir
    ) {
        $this->httpClient = $httpClient;
        $this->sentMessageRepository = $sentMessageRepository;
        $this->vkAccessToken = $vkAccessToken;
        $this->vkApiVersion = $vkApiVersion;
        $this->vkScriptsDir = $vkScriptsDir;
    }

    /**
     * @return SentPersonalMessagePack[]
     */
    public function sendMessage(string $message, array $recipients): array
    {
        $rawRecipients = array_map(function (VkUser $recipient): int {
            return $recipient->getId();
        }, $recipients);

        $response = $this->httpClient->request(
            'POST',
            'https://api.vk.com/method/execute',
            [
                'json' => [
                    'accessToken' => $this->vkAccessToken,
                    'v' => $this->vkApiVersion,
                    'code' => file_get_contents($this->vkScriptsDir . '/send_2500_messages.vk.js'),
                    'message' => $message,
                    'rawRecipients' => implode(',', $rawRecipients),
                    'nextMessageIdentifier' => $this->sentMessageRepository->getNextMessageIdentifier(),
                ],
            ]
        );

        $jsonResponse = json_decode($response->getBody(), true);

        return array_map(function (array $sentMessagePack): SentPersonalMessagePack {
            $messages = array_map(function (array $sentMessage): SentPersonalMessage {
                return new SentPersonalMessage(
                    new VkUser($sentMessage['userId']),
                    $sentMessage['messageId'],
                    $sentMessage['errorMessage']
                );
            }, $sentMessagePack['messages']);

            return new SentPersonalMessagePack(
                $sentMessagePack['uniqueIdentifier'],
                $messages
            );
        }, $jsonResponse['sentMessages']);
    }
}
