<?php

namespace BaksDev\Reference\Gender\Type;

/**
 * Типы полей
 */
final class Gender
{
    
    public const TYPE = 'gender_type';
    
    /**
     * @var GenderEnum
     */
    private GenderEnum $gender;
    
    /**
     * Field constructor
     *
     * @param string|GenderEnum $gender
     */
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
    
    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->gender->value;
    }
    
    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->gender->value;
    }
    
    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->gender->name;
    }
    
    /**
     * @return array
     */
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