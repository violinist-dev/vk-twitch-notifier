<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class DeserializationHandler
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack
    ) {
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
    }

    public function handle(string $type): object
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        return $this->serializer->deserialize(
            $request->getContent(),
            $type,
            JsonEncoder::FORMAT
        );
    }
}
