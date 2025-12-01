<?php

namespace App\Tests\Services;

use App\Services\Day5Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day5ServicesTest extends TestCase
{
    private array $rules = [
        47 => [53, 13, 61, 29],
        97 => [13, 61, 47, 29, 53, 75],
        75 => [29, 53, 47, 61, 13],
        61 => [13, 53, 29],
        29 => [13],
        53 => [29, 13],
    ];

    private array $updates = [
        [75,47,61,53,29],
        [97,61,53,29,13],
        [75,29,13],
        [75,97,47,61,53],
        [61,13,29],
        [97,13,75,29,47]
    ];

    public function testPageAfterCount(): void
    {
        $number = 75;
        $day5Service = new Day5Services();

        $update = [75,47,61,53,29];

        self::assertSame(4, $day5Service->pageAfterCount($number, $update, $this->rules));
    }

    public function testGetOrderedUpdate(): void
    {
        $update = [75,97,47,61,53];
        $expectedUpdate = [97,75,47,61,53];

        $day5Service = new Day5Services();

        self::assertSame($expectedUpdate, $day5Service->getOrderedUpdate($update, $this->rules));
    }

    #[DataProvider('isUpdateInRightOrderDataProvider')]
    public function testIsUpdateInRightOrder(array $update, bool $expected): void
    {
        $day5Service = new Day5Services();

        self::assertSame($expected, $day5Service->isUpdateInRightOrder($update, $this->rules));
    }

    private function isUpdateInRightOrderDataProvider(): \Generator
    {
        yield 'In order update' => [
            [75,47,61,53,29],
            true,
        ];
        yield 'Not in order update' => [
            [75,97,47,61,53],
            false,
        ];
    }
}
