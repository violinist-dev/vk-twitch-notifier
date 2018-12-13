<?php

declare(strict_types=1);

namespace App\Tests\Test\Action\VkCallbackAction;

use App\Tests\Test\AbstractFunctionalTest;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

class MessageNewTest extends AbstractFunctionalTest
{
    public function testSuccessfulMessageSending(): void
    {
        $response = $this->request('POST', '/vk-callback?' . http_build_query([
            'webhookAccessToken' => $this->vkWebhookSecret,
        ]), [
            'type' => 'message_new',
            'group_id' => $this->vkMessageSenderCommunityId,
            'object' => [
                'from_id' => 1,
                'text' => 'test',
            ],
        ]);

        $this->assertStatusCode(Response::HTTP_OK);

        Assert::assertEquals('ok', $response->getContent());
    }
}
