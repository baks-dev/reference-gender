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

namespace BaksDev\Reference\Gender\Type\Tests;

use BaksDev\Reference\Gender\Type\Gender;
use BaksDev\Reference\Gender\Type\Genders\GenderCollection;
use BaksDev\Reference\Gender\Type\GenderType;
use BaksDev\Wildberries\Orders\Type\WildberriesStatus\Status\Collection\WildberriesStatusInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Attribute\When;

/**
 * @group reference-gender
 */
#[When(env: 'test')]
final class GenderTest extends KernelTestCase
{
    public function testUseCase(): void
    {
        /** @var GenderCollection $GenderCollection */
        $GenderCollection = self::getContainer()->get(GenderCollection::class);

        /** @var WildberriesStatusInterface $case */
        foreach($GenderCollection->cases() as $case)
        {
            $Gender = new Gender($case->getValue());

            self::assertTrue($Gender->equals($case::class)); // немспейс интерфейса
            self::assertTrue($Gender->equals($case)); // объект интерфейса
            self::assertTrue($Gender->equals($case->getValue())); // срока
            self::assertTrue($Gender->equals($Gender)); // объект класса

            $GenderType = new GenderType();
            $platform = $this->getMockForAbstractClass(AbstractPlatform::class);

            $convertToDatabase = $GenderType->convertToDatabaseValue($Gender, $platform);
            self::assertEquals($Gender->getGenderValue(), $convertToDatabase);

            $convertToPHP = $GenderType->convertToPHPValue($convertToDatabase, $platform);
            self::assertInstanceOf(Gender::class, $convertToPHP);
            self::assertEquals($case, $convertToPHP->getGender());

        }

        self::assertTrue(true);

    }
}