<?php

declare(strict_types=1);

namespace App\Tests\Test;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\TestContainer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractFunctionalTest extends WebTestCase
{
    /**
     * @var string
     */
    protected $vkCallbackToken;

    /**
     * @var int
     */
    protected $vkMessageSenderCommunityId;

    /**
     * @var string
     */
    protected $vkWebhookSecret;

    /**
     * @var Client
     */
    private $client;

    protected function assertStatusCode(int $statusCode): void
    {
        static::assertEquals(
            $statusCode,
            $this->client->getResponse()->getStatusCode(),
            sprintf(
                'Expected status code: %d, actual status code: %d. Response:' . "\n\n" . '%s',
                $statusCode,
                $this->client->getResponse()->getStatusCode(),
                $this->getPrettyResponseJson()
            )
        );
    }

    protected function getPrettyResponseJson(): string
    {
        return json_encode(
            json_decode($this->client->getResponse()->getContent()),
            JSON_PRETTY_PRINT
        );
    }

    protected function request(
        string $method,
        string $url,
        $data = null,
        array $headers = [],
        array $files = []
    ): Response {
        $data = is_array($data) ? json_encode($data) : $data;

        $defaultHeaders = [
            'HTTP_ACCEPT' => 'application/hal+json,application/problem+json,application/json',
        ];

        if (!empty($data)) {
            $defaultHeaders['HTTP_CONTENT-TYPE'] = 'application/json';
        }

        foreach ($headers as $key => $value) {
            $headers['HTTP_' . mb_strtoupper($key)] = $value;
            unset($headers[$key]);
        }

        $requestHeaders = $defaultHeaders + $headers;

        $this->client->request($method, $url, [], $files, $requestHeaders, $data);

        return $this->client->getResponse();
    }

    public function setup(): void
    {
        $this->client = static::createClient();

        /** @var TestContainer */
        $container = self::$container->get('test.service_container');

        // Parameters
        $this->vkMessageSenderCommunityId = (int) $container->getParameter('env.vk_message_sender_community_id');
        $this->vkCallbackToken = $container->getParameter('env.vk_callback_token');
        $this->vkWebhookSecret = $container->getParameter('env.vk_webhook_secret');
    }

    protected function tearDown(): void
    {
    }
}
