<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\User\ValueObject\ProfileId;

class ProfileIdType extends StringType
{
    public const NAME = 'profile_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ProfileId
    {
        return $value !== null ? ProfileId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ProfileId ? (string) $value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
