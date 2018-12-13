<?php

declare(strict_types=1);

namespace App\Serializer\Denormalizer;

use App\Dto\MessageNewRequest;
use App\Exception\DeserializationFailedException;
use App\ValueObject\IncomingVkMessage;
use App\ValueObject\VkUser;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function App\traversableToArray;

class IncomingVkMessageDenormalizer implements DenormalizerInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        ValidatorInterface $validator
    ) {
        $this->validator = $validator;
    }

    /**
     * @param mixed      $data
     * @param mixed      $class
     * @param mixed|null $format
     *
     * @return IncomingVkMessage
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if ($this->supportsDenormalization($data, $class, $format) === false) {
            throw new InvalidArgumentException('Could not denormalize the object');
        }

        $dto = new MessageNewRequest();
        $dto->groupId = $data['group_id'] ?? null;
        $dto->type = $data['type'] ?? null;
        $dto->sender = $data['object']['from_id'] ?? null;
        $dto->text = $data['object']['text'] ?? null;

        $violations = $this->validator->validate($dto);

        if ($violations->count() > 0) {
            throw new DeserializationFailedException(traversableToArray($violations));
        }

        return new IncomingVkMessage(
            new VkUser($dto->sender),
            $dto->text
        );
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $format === JsonEncoder::FORMAT && $type === IncomingVkMessage::class;
    }
}
