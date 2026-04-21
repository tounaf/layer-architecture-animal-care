<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Shared\ValueObject\ClientId;

class ClientIdType extends StringType
{
    public const NAME = 'client_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ClientId
    {
        return $value !== null ? ClientId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ClientId ? (string) $value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
