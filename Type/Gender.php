<?php
/*
 *  Copyright 2025.  Baks.dev <admin@baks.dev>
 *  
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is furnished
 *  to do so, subject to the following conditions:
 *  
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *  
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

namespace BaksDev\Reference\Gender\Type;

use BaksDev\Reference\Gender\Type\Genders\Collection\GenderBoy;
use BaksDev\Reference\Gender\Type\Genders\Collection\GenderGirl;
use BaksDev\Reference\Gender\Type\Genders\Collection\GenderMen;
use BaksDev\Reference\Gender\Type\Genders\Collection\GenderUnisex;
use BaksDev\Reference\Gender\Type\Genders\GenderInterface;
use InvalidArgumentException;

/** Различие пола и гендера */
final class Gender
{
    public const string TYPE = 'gender_type';

    public const string TEST = GenderMen::class;

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


    public static function cases(bool $unisex = true): array
    {
        $case = [];

        foreach(self::getDeclared() as $key => $gender)
        {
            if(false === $unisex && in_array($gender, [GenderUnisex::class, GenderBoy::class, GenderGirl::class], true))
            {
                continue;
            }

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

    /**
     * Метод фильтрует значение, удаляя его из строки
     */
    public function filter(string $gender): string
    {
        $haystack = array_map("mb_strtolower", $this->gender::HAYSTACK);

        $gender = mb_strtolower($gender);
        $gender = (string) str_ireplace($haystack, '', $gender);
        $gender = preg_replace('/\s+/', ' ', $gender);
        $gender = trim($gender);

        return mb_ucfirst($gender);
    }

}