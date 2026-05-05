<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Medicament\ValueObject\MedicamentId;

class MedicamentIdType extends StringType
{
    public const NAME = 'medicament_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?MedicamentId
    {
        return $value !== null ? MedicamentId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof MedicamentId ? (string) $value : $value;
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
