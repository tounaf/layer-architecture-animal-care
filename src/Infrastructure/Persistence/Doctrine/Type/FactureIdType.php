<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Facture\ValueObject\FactureId;

class FactureIdType extends StringType
{
    public const NAME = 'facture_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?FactureId
    {
        return $value !== null ? FactureId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof FactureId ? (string) $value : $value;
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
