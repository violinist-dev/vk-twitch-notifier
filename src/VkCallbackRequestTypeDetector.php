<?php

declare(strict_types=1);

namespace App;

use App\Enum\VkCallbackRequestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class VkCallbackRequestTypeDetector
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

        return new VkCallbackRequestType($data['type']);
    }
}
