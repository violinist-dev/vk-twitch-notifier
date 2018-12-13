<?php

declare(strict_types=1);

namespace App\Tests\Test\Action\VkCallbackAction;

use App\Tests\Test\AbstractFunctionalTest;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

class CallbackTest extends AbstractFunctionalTest
{
    public function testSuccessfulConfirmationCallback(): void
    {
        $response = $this->request('POST', '/vk-callback?' . http_build_query([
            'webhookAccessToken' => $this->vkWebhookSecret,
        ]), [
            'type' => 'confirmation',
            'group_id' => $this->vkMessageSenderCommunityId,
        ]);

        $this->assertStatusCode(Response::HTTP_OK);

        Assert::assertEquals($this->vkCallbackToken, $response->getContent());
    }

    public function testUnsuccessfulConfirmationCallback(): void
    {
        $response = $this->request('POST', '/vk-callback?' . http_build_query([
            'webhookAccessToken' => $this->vkWebhookSecret,
        ]), [
            'type' => 'confirmation',
            'group_id' => 734534645,
        ]);

        $this->assertStatusCode(Response::HTTP_BAD_REQUEST);

        Assert::assertJsonStringEqualsJsonString(json_encode([
            'type' => 'validation_error',
            'status' => 400,
            'title' => 'Validation Error',
            'detail' => 'There are some invalid fields in your JSON payload. See "violations" field.',
            'instance' => null,
            'violations' => [
                [
                    'propertyPath' => 'groupId', // TODO: Replace with group_id
                    'message' => 'This VK community is not supported by the service.',
                ],
            ],
        ]), $response->getContent());
    }
}
