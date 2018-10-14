<?php

namespace App\Serializer\Denormalizer;

use App\Dto\CallbackConfirmationRequest;
use App\Exception\DeserializationFailedException;
use function App\traversableToArray;
use App\ValueObject\CallbackConfirmation;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CallbackConfirmationDenormalizer implements DenormalizerInterface
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
     * @return CallbackConfirmation
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if ($this->supportsDenormalization($data, $class, $format) === false) {
            throw new InvalidArgumentException('Could not denormalize the object');
        }

        $dto = new CallbackConfirmationRequest();
        $dto->groupId = $data['group_id'] ?? null;
        $dto->type = $data['type'] ?? null;

        $violations = $this->validator->validate($dto);

        if ($violations->count() > 0) {
            throw new DeserializationFailedException(traversableToArray($violations));
        }

        return new CallbackConfirmation(
            $dto->groupId
        );
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $format === JsonEncoder::FORMAT && $type === CallbackConfirmation::class;
    }
}
