<?php

declare(strict_types=1);

namespace App\Tests\Test\Action;

use App\Tests\Test\AbstractFunctionalTest;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

class VkCallbackActionTest extends AbstractFunctionalTest
{
    public function testSuccessfulConfirmationCallback(): void
    {
        $response = $this->request('POST', '/vk-callback', [
            'type' => 'confirmation',
            'group_id' => $this->vkCommunityId,
        ]);

        $this->assertStatusCode(Response::HTTP_OK);

        Assert::assertEquals($this->vkCallbackConfirmationToken, $response->getContent());
    }

    public function testUnknownCallbackType(): void
    {
        $response = $this->request('POST', '/vk-callback', [
            'type' => 'unknown_type',
        ]);

        $this->assertStatusCode(Response::HTTP_BAD_REQUEST);

        Assert::assertEquals('unsupported callback type', $response->getContent());
    }

    public function testUnsuccessfulConfirmationCallback(): void
    {
        $response = $this->request('POST', '/vk-callback', [
            'type' => 'confirmation',
            'group_id' => 1,
        ]);

        $this->assertStatusCode(Response::HTTP_BAD_REQUEST);

        echo $response->getContent();

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
