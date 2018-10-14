<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\ValueObject\ApiProblem;
use App\ValueObject\ValidationErrorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiProblemNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param ApiProblem $object
     * @param mixed|null $format
     *
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$this->supportsNormalization($object, $format)) {
            throw new InvalidArgumentException('Could not normalize the object');
        }

        $schema = [
            'type' => $object->getType(),
            'status' => $object->getStatus(),
            'title' => $object->getTitle(),
            'detail' => $object->getDetail(),
            'instance' => $object->getInstance(),
        ];

        if ($object instanceof ValidationErrorInterface) {
            $schema['violations'] = $object->getConstraintViolations();
        }

        return $this->normalizer->normalize($schema, $format, $context);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $format === JsonEncoder::FORMAT && $data instanceof ApiProblem;
    }
}
