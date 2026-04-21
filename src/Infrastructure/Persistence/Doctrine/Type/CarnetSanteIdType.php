<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Care\ValueObject\CarnetSanteId;

class CarnetSanteIdType extends StringType
{
    public const NAME = 'carnet_sante_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => $column['length'] ?? 39,
            'fixed' => false,
        ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CarnetSanteId
    {
        return $value !== null ? CarnetSanteId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof CarnetSanteId ? (string) $value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
