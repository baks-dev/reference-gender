<?php

namespace BaksDev\Reference\Gender\Type;

use BaksDev\Reference\Gender\Type\Genders\Collection\GenderInterface;
use BaksDev\Reference\Gender\Type\Genders\GenderMen;
use InvalidArgumentException;

/** Различие пола и гендера */
final class Gender
{
    public const TYPE = 'gender_type';

    public const TEST = GenderMen::class;

    private GenderInterface $gender;


    public function __construct(GenderInterface|self|string $gender)
    {
        if(is_string($gender) && class_exists($gender))
        {
            $instance = new $gender();

            if($instance instanceof GenderInterface)
            {
                $this->gender = $instance;
                return;
            }
        }

        if($gender instanceof GenderInterface)
        {
            $this->gender = $gender;
            return;
        }

        if($gender instanceof self)
        {
            $this->gender = $gender->getGender();
            return;
        }

        /** @var GenderInterface $declare */
        foreach(self::getDeclared() as $declare)
        {
            if($declare::equals($gender))
            {
                $this->gender = new $declare;
                return;
            }
        }

        throw new InvalidArgumentException(sprintf('Not found Gender %s', $gender));
    }


    public function __toString(): string
    {
        return $this->gender->getValue();
    }


    public static function cases(): array
    {
        $case = [];

        foreach(self::getDeclared() as $key => $gender)
        {
            /** @var GenderInterface $gender */
            $class = new $gender;
            $case[$class::sort().$key] = new self($gender);
        }

        ksort($case);

        return $case;
    }

    public static function getDeclared(): array
    {
        return array_filter(
            get_declared_classes(),
            static function($className) {
                return in_array(GenderInterface::class, class_implements($className), true);
            }
        );
    }


    public function equals(mixed $status): bool
    {
        $status = new self($status);

        return $this->getGenderValue() === $status->getGenderValue();
    }


    public function getGender(): GenderInterface
    {
        return $this->gender;
    }


    public function getGenderValue(): string
    {
        return $this->gender->getValue();
    }


}