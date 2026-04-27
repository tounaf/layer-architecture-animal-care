<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Prestation\ValueObject\PrestationId;

class PrestationIdType extends StringType
{
    public const NAME = 'prestation_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => $column['length'] ?? 39,
            'fixed' => false,
        ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PrestationId
    {
        return $value !== null ? PrestationId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof PrestationId ? (string) $value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
