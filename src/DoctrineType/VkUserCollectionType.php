<?php

declare(strict_types=1);

namespace App\DoctrineType;

use App\ValueObject\VkUser;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class VkUserCollectionType extends Type
{
    public const TYPE = 'vk_user_collection';

    /**
     * @param VkUser[]|null $value
     *
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return json_encode(array_map(function (VkUser $vkUser): int {
            return $vkUser->getId();
        }, $value));
    }

    /**
     * @param string
     * @param mixed $value
     *
     * @return VkUser[]
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return array_map(function (int $vkUserId): VkUser {
            return new VkUser($vkUserId);
        }, json_decode($value, true));
    }

    public function getName()
    {
        return self::TYPE;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getJsonTypeDeclarationSQL($fieldDeclaration);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
