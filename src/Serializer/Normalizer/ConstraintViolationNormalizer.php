<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ConstraintViolationNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param ConstraintViolationInterface $object
     * @param mixed|null          $format
     *
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$this->supportsNormalization($object, $format)) {
            throw new InvalidArgumentException('Could not normalize the object');
        }

        $schema = [
            'propertyPath' => $object->getPropertyPath(),
            'message' => $object->getMessage(),
        ];

        return $this->normalizer->normalize($schema, $format, $context);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $format === JsonEncoder::FORMAT && $data instanceof ConstraintViolationInterface;
    }
}
