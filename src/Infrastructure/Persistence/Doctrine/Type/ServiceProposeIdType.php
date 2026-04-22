<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Prestataire\ValueObject\ServiceProposeId;

class ServiceProposeIdType extends StringType
{
    public const NAME = 'service_propose_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => $column['length'] ?? 39,
            'fixed' => false,
        ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ServiceProposeId
    {
        return $value !== null ? ServiceProposeId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ServiceProposeId ? (string) $value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
