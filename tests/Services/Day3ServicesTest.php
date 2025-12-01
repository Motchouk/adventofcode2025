<?php

namespace App\Tests\Services;

use App\Services\Day3Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day3ServicesTest extends TestCase
{
    #[DataProvider('getMultiplyOperationsValues')]
    public function testMultiplyOperationsValues(array $mulOperations, int $expectedValue): void
    {
        $day3Service = new Day3Services();

        self::assertSame($expectedValue, $day3Service->multiplyOperationsValues($mulOperations));
    }

    public static function getMultiplyOperationsValues(): \Generator
    {
        yield 'Test from ADV' => [
            ['mul(2,4)', 'mul(5,5)', 'mul(11,8)', 'mul(8,5)'],
            161,
        ];

        yield 'Test with 0 just in case' => [
            ['mul(2,0)', 'mul(5,5)', 'mul(11,8)', 'mul(8,5)'],
            153,
        ];
    }

    public function testGetMulOperations(): void
    {
        $day3Service = new Day3Services();

        $string = 'xmul(2,4)%&mul[3,7]!@^do_not_mul(5,5)+mul(32,64]then(mul(11,8)mul(8,5))';
        $expectedArray = ['mul(2,4)', 'mul(5,5)', 'mul(11,8)', 'mul(8,5)'];

        self::assertSame($expectedArray, $day3Service->getMulOperations([$string]));
    }
}
