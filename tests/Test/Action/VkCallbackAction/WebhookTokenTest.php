<?php

declare(strict_types=1);

namespace App\Tests\Test\Action\VkCallbackAction;

use App\Tests\Test\AbstractFunctionalTest;
use Symfony\Component\HttpFoundation\Response;

class WebhookTokenTest extends AbstractFunctionalTest
{
    public function testInvalidWebhookToken(): void
    {
        $response = $this->request('POST', '/vk-callback?' . http_build_query([
            'webhookAccessToken' => 'invalid_webhook_token',
        ]), [
            'type' => 'confirmation',
            'group_id' => $this->vkMessageSenderCommunityId,
        ]);

        $this->assertStatusCode(Response::HTTP_FORBIDDEN);
    }
}
