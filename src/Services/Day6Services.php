<?php

namespace App\Services;

class Day6Services
{
    private array $grid = [];

    private int $result = 0;

    public function __construct(
        private readonly CalendarServices $calendarServices
    ){}

    public function process(array $lines, int $part): int
    {
        $lines = $this->calendarServices->parseInputFromStringsWithSpaceToArray($lines);

        if (1 === $part) {
            $this->applyOperationsOnColumns($lines);
        }

        return $this->result;
    }

    private function applyOperationsOnColumns(array $lines): void
    {
        for ($i = 0; $i < count($lines[0]); $i++) {
            $column = $this->getColumn($lines, $i);

            $operator = array_pop($column);

            $result = match($operator) {
                '+' => array_sum($column),
                '*' => array_product($column),
            };

            $this->result += $result;
        }
    }

    private function getColumn(array $lines, int $index): array
    {
        $column = [];
        $colIndex = 0;

        while (isset($lines[$colIndex][$index])) {
            $column[] = $lines[$colIndex][$index];
            $colIndex++;
        }

        return $column;
    }
}