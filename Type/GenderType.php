<?php

namespace BaksDev\Reference\Gender\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

final class GenderType extends Type
{
	public function convertToDatabaseValue($value, AbstractPlatform $platform): string
	{
		return (string) $value;
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): ?Gender
	{
        return !empty($value) ? new Gender($value) : null;
	}
	
	
	public function getName(): string
	{
		return Gender::TYPE;
	}
	
	
	public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
	{
		return true;
	}

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }
	
}