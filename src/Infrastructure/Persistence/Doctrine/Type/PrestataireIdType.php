<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Shared\ValueObject\PrestataireId;

class PrestataireIdType extends StringType
{
    public const NAME = 'prestataire_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PrestataireId
    {
        return $value !== null ? PrestataireId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof PrestataireId ? (string) $value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
