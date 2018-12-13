<?php

declare(strict_types=1);

namespace App\Tests\Test\Action\VkCallbackAction;

use App\Tests\Test\AbstractFunctionalTest;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

class UnknownTypeTest extends AbstractFunctionalTest
{
    public function testUnknownCallbackType(): void
    {
        $response = $this->request('POST', '/vk-callback?' . http_build_query([
            'webhookAccessToken' => $this->vkWebhookSecret,
        ]), [
            'type' => 'unknown_type',
        ]);

        $this->assertStatusCode(Response::HTTP_BAD_REQUEST);

        Assert::assertEquals('unsupported callback type', $response->getContent());
    }
}
