<?php

declare(strict_types=1);

namespace App;

use App\Enum\VkCallbackRequestType;
use App\ValueObject\IncomingVkMessage;
use App\ValueObject\VkUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class VkCallbackParser
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        RequestStack $requestStack
    ) {
        $this->requestStack = $requestStack;
    }

    public function getCallbackType(): ?VkCallbackRequestType
    {
        $data = $this->getCallbackData();

        if ($data === null) {
            return null;
        }

        return new VkCallbackRequestType($data['type']);
    }

    public function getIncomingMessage(): ?IncomingVkMessage
    {
        $newMessageType = new VkCallbackRequestType(VkCallbackRequestType::MESSAGE_NEW);

        if ($this->getCallbackType() === null or $this->getCallbackType()->equals($newMessageType) === false) {
            return null;
        }

        $data = $this->getCallbackData();

        if (isset($data['object']['from_id']) === false) {
            return null;
        }

        if (is_int($data['object']['from_id']) === false) {
            return null;
        }

        if (isset($data['object']['text']) === false) {
            return null;
        }

        if (is_string($data['object']['text']) === false) {
            return null;
        }

        return new IncomingVkMessage(
            new VkUser($data['object']['from_id']),
            $data['object']['text']
        );
    }

    private function getCallbackData(): ?array
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var string $requestContent */
        $requestContent = $request->getContent();

        if ($requestContent === '') {
            return null;
        }

        $data = json_decode($requestContent, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return null;
        }

        if (isset($data['type']) === false) {
            return null;
        }

        if (is_string($data['type']) === false) {
            return null;
        }

        if (VkCallbackRequestType::isValid($data['type']) === false) {
            return null;
        }

        return $data;
    }
}
