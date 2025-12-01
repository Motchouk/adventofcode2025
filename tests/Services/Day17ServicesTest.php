<?php

namespace App\Tests\Services;

use App\Services\Day17Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day17ServicesTest extends TestCase
{

    #[DataProvider('xdvDataProvider')]
    public function testXdv(array $values, int $expectedValue): void
    {
        $day17Service = new Day17Services();
        $day17Service->setRegister('A', $values['A']);
        $day17Service->setRegister('B', $values['B']);
        $day17Service->xdv($values['x'], $values['comboOperator']);

        self::assertSame($expectedValue, $day17Service->getRegister($values['x']));
    }

    public static function xdvDataProvider(): \Generator
    {
        yield 'ADV - numeric combo operator' => [
            ['A' => 20, 'B' => 3, 'comboOperator' => 2, 'x' => 'A'],
            5,
        ];

        yield 'ADV - alpha combo operator' => [
            ['A' => 20, 'B' => 3, 'comboOperator' => 5, 'x' => 'A'],
            2,
        ];

        yield 'BDV - numeric combo operator' => [
            ['A' => 20, 'B' => 3, 'comboOperator' => 2, 'x' => 'B'],
            5,
        ];

        yield 'BDV - alpha combo operator' => [
            ['A' => 20, 'B' => 3, 'comboOperator' => 5, 'x' => 'B'],
            2,
        ];

        yield 'CDV - numeric combo operator' => [
            ['A' => 20, 'B' => 3, 'comboOperator' => 2, 'x' => 'C'],
            5,
        ];

        yield 'CDV - alpha combo operator' => [
            ['A' => 20, 'B' => 3, 'comboOperator' => 5, 'x' => 'C'],
            2,
        ];
    }

    public function testBxl():void
    {
        $day17Service = new Day17Services();
        $day17Service->setRegister('B', 29);
        $day17Service->bxl(7);

        self::assertSame(26, $day17Service->getRegister('B'));
    }

    public function testBxc():void
    {
        $day17Service = new Day17Services();
        $day17Service->setRegister('B', 2024);
        $day17Service->setRegister('C', 43690);
        $day17Service->bxc(0);

        self::assertSame(44354, $day17Service->getRegister('B'));
    }

    public function testBst():void
    {
        $day17Service = new Day17Services();
        $day17Service->setRegister('B', 29);
        $day17Service->setRegister('C', 9);
        $day17Service->bst(6);

        self::assertSame(1, $day17Service->getRegister('B'));
    }
}
