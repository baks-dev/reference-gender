<?php

namespace BaksDev\Reference\Gender\Type;

/** Различие пола и гендера */
final class Gender
{
	public const TYPE = 'gender_type';
	
	private GenderEnum $gender;
	
	
	public function __construct(string|GenderEnum $gender)
	{
		if($gender instanceof GenderEnum)
		{
			$this->gender = $gender;
		}
		else
		{
			$this->gender = GenderEnum::from($gender);
		}
	}
	
	
	public function __toString() : string
	{
		return $this->gender->value;
	}
	
	
	public function getValue() : string
	{
		return $this->gender->value;
	}
	
	
	public function getName() : string
	{
		return $this->gender->name;
	}
	
	
	public static function cases() : array
	{
		$case = null;
		
		foreach(GenderEnum::cases() as $gender)
		{
			$case[] = new self($gender);
		}
		
		return $case;
	}
	
}