<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Care\ValueObject\EntreeCarnetId;

class EntreeCarnetIdType extends StringType
{
    public const NAME = 'entree_carnet_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => $column['length'] ?? 39,
            'fixed' => false,
        ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?EntreeCarnetId
    {
        return $value !== null ? EntreeCarnetId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof EntreeCarnetId ? (string) $value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
