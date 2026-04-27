<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Service\ValueObject\ServiceChampId;

class ServiceChampIdType extends StringType
{
    public const NAME = 'service_champ_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => $column['length'] ?? 39,
            'fixed' => false,
        ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ServiceChampId
    {
        return $value !== null ? ServiceChampId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ServiceChampId ? (string) $value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
