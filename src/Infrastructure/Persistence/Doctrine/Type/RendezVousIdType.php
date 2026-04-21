<?php

namespace Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\RendezVous\ValueObject\RendezVousId;

class RendezVousIdType extends StringType
{
    public const NAME = 'rendez_vous_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?RendezVousId
    {
        return $value !== null ? RendezVousId::fromString($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof RendezVousId ? (string) $value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
