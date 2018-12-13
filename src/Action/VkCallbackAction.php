<?php

declare(strict_types=1);

namespace App\Action;

use App\DeserializationHandler;
use App\Enum\VkCallbackRequestType;
use App\Message\ReplyToMessage;
use App\UserMessageTypeDetector;
use App\ValueObject\CallbackConfirmation;
use App\ValueObject\IncomingVkMessage;
use App\VkCallbackParser;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class VkCallbackAction
{
    /**
     * @var DeserializationHandler
     */
    private $deserializationHandler;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var UserMessageTypeDetector
     */
    private $userMessageTypeDetector;

    /**
     * @var VkCallbackParser
     */
    private $vkCallbackParser;

    /**
     * @var string
     */
    private $vkCallbackToken;

    /**
     * @var string
     */
    private $vkWebhookSecret;

    public function __construct(
        RequestStack $requestStack,
        MessageBusInterface $messageBus,
        DeserializationHandler $deserializationHandler,
        VkCallbackParser $vkCallbackParser,
        UserMessageTypeDetector $userMessageTypeDetector,
        string $vkCallbackToken,
        string $vkWebhookSecret
    ) {
        $this->requestStack = $requestStack;
        $this->messageBus = $messageBus;
        $this->deserializationHandler = $deserializationHandler;
        $this->vkCallbackParser = $vkCallbackParser;
        $this->userMessageTypeDetector = $userMessageTypeDetector;
        $this->vkCallbackToken = $vkCallbackToken;
        $this->vkWebhookSecret = $vkWebhookSecret;
    }

    private function handleConfirmationCallback(): Response
    {
        $this->deserializationHandler->handle(CallbackConfirmation::class);

        return new Response(
            $this->vkCallbackToken,
            Response::HTTP_OK
        );
    }

    private function handleMessageNewCallback(): Response
    {
        /** @var IncomingVkMessage $incomingMessage */
        $incomingMessage = $this->deserializationHandler->handle(IncomingVkMessage::class);
        $messageType = $this->userMessageTypeDetector->detectType($incomingMessage);

        $this->messageBus->dispatch(new ReplyToMessage($messageType));

        return new Response(
            'ok',
            Response::HTTP_OK
        );
    }

    private function isWebhookAccessTokenValid(Request $request): bool
    {
        return $request->get('webhookAccessToken') !== $this->vkWebhookSecret;
    }

    /**
     * @Route("/vk-callback", name="vk_callback", methods={"POST"})
     */
    public function __invoke(): Response
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        if ($this->isWebhookAccessTokenValid($request)) {
            return new Response(
                'Webhook access token is incorrect.',
                Response::HTTP_FORBIDDEN
            );
        }

        $callbackType = $this->vkCallbackParser->getCallbackType();

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
