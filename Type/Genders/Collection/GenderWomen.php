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

declare(strict_types=1);

namespace BaksDev\Reference\Gender\Type\Genders\Collection;

use BaksDev\Reference\Gender\Type\Genders\GenderInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('baks.gender')]
final class GenderWomen implements GenderInterface
{
    public const string GENDER = 'women';

    public const array HAYSTACK = [
        'Женская',
        'Женской',
        'Женские',
        'Женское',
        'women',
    ];

    public function getValue(): string
    {
        return self::GENDER;
    }

    /**
     * Сортировка (чем меньше число - тем первым в итерации будет значение)
     */
    public static function sort(): int
    {
        return 2;
    }

    public static function equals(string $gender): bool
    {
        return array_any(self::HAYSTACK, static fn($item
        ) => str_contains(mb_strtolower($gender), mb_strtolower($item)));
    }

    /**
     * Метод фильтрует значение, удаляя его из строки
     */
    public static function filter(string $gender): string
    {
        $haystack = array_map("mb_strtolower", self::HAYSTACK);

        $gender = mb_strtolower($gender);
        $gender = (string) str_ireplace($haystack, '', $gender);
        $gender = preg_replace('/\s/', ' ', $gender);
        $gender = trim($gender);

        return mb_ucfirst($gender);
    }
}