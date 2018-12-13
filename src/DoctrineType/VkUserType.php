<?php

declare(strict_types=1);

namespace App\DoctrineType;

use App\ValueObject\VkUser;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class VkUserType extends Type
{
    public const TYPE = 'vk_user';

    /**
     * @param VkUser|null $value
     *
     * @return int
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return $value->getId();
    }

    /**
     * @param int
     * @param mixed $value
     *
     * @return VkUser
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return new VkUser($value);
    }

    public function getName()
    {
        return self::TYPE;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getBigIntTypeDeclarationSQL($fieldDeclaration);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
