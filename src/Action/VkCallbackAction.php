<?php

declare(strict_types=1);

namespace App\Action;

use App\DeserializationHandler;
use App\Enum\VkCallbackRequestType;
use App\ValueObject\CallbackConfirmation;
use App\VkCallbackRequestTypeDetector;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VkCallbackAction
{
    /**
     * @var DeserializationHandler
     */
    private $deserializationHandler;

    /**
     * @var string
     */
    private $vkCallbackConfirmationToken;

    /**
     * @var VkCallbackRequestTypeDetector
     */
    private $vkCallbackRequestTypeDetector;

    public function __construct(
        DeserializationHandler $deserializationHandler,
        VkCallbackRequestTypeDetector $vkCallbackRequestTypeDetector,
        string $vkCallbackConfirmationToken
    ) {
        $this->deserializationHandler = $deserializationHandler;
        $this->vkCallbackRequestTypeDetector = $vkCallbackRequestTypeDetector;
        $this->vkCallbackConfirmationToken = $vkCallbackConfirmationToken;
    }

    private function handleConfirmationCallback(): Response
    {
        $this->deserializationHandler->handle(CallbackConfirmation::class);

        return new Response(
            $this->vkCallbackConfirmationToken,
            Response::HTTP_OK
        );
    }

    private function handleMessageNewCallback(): Response
    {
        return new Response(
            'ok',
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/vk-callback", name="vk_callback", methods={"POST"})
     */
    public function __invoke(): Response
    {
        $callbackType = $this->vkCallbackRequestTypeDetector->getCallbackType();

        if ($callbackType === null) {
            return new Response('unsupported callback type', Response::HTTP_BAD_REQUEST);
        }

        if ($callbackType->equals(new VkCallbackRequestType(VkCallbackRequestType::CONFIRMATION))) {
            return $this->handleConfirmationCallback();
        } elseif ($callbackType->equals(new VkCallbackRequestType(VkCallbackRequestType::MESSAGE_NEW))) {
            return $this->handleMessageNewCallback();
        }

        throw new RuntimeException('Unhandled callback type: ' . $callbackType->getValue());
    }
}
