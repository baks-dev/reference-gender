<?php

namespace BaksDev\Reference\Gender\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class GenderType extends StringType
{
	public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
	{
		return (string) $value;
	}
	
	
	public function convertToPHPValue($value, AbstractPlatform $platform): mixed
	{
		return new Gender($value);
	}
	
	
	public function getName(): string
	{
		return Gender::TYPE;
	}
	
	
	public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
	{
		return true;
	}
	
}