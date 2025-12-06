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
        if (1 === $part) {
            $lines = $this->calendarServices->parseInputFromStringsWithSpaceToArray($lines);
            $this->applyOperationsOnColumns($lines);
        }

        if (2 === $part) {
            $lines = $this->calendarServices->parseInputFromStringsToArray($lines);
            $this->applyOperationsOnIndexes($lines);
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

    private function applyOperationsOnIndexes(array $lines): void
    {
        $resetOperator = true;
        $operator = '';
        $numbers = [];
        $maxLineLength = $this->getMaxLineLength($lines);

        // Parcours des columns
        for ($i = 0; $i <= $maxLineLength; $i++) {
            $column = $this->getIndexColumn($lines, $i);

            if (empty($column)) {
                $resetOperator = true;

                $result = match($operator) {
                    '+' => array_sum($numbers),
                    '*' => array_product($numbers),
                };

                $this->result += $result;
                $numbers = [];

                continue;
            }

            if ($resetOperator) {
                $operator = array_pop($column);
                $resetOperator = false;
            }

            $numbers[] = (int) implode('', $column);
        }
    }

    private function getIndexColumn(array $lines, int $index): array
    {
        $result = [];
        $line = 0;

        while (isset($lines[$line])) {
            if (isset($lines[$line][$index]) && ' ' !== $lines[$line][$index]) {
                $result[] = ($lines[$line][$index] === '+' || $lines[$line][$index] === '*')
                    ? $lines[$line][$index]
                    : (int) $lines[$line][$index];
            }

            ++$line;
        }
        return $result;
    }

    private function getMaxLineLength(array $lines): int
    {
        $maxLineLength = 0;

        for ($i = 0; $i < count($lines); $i++) {
            $maxLineLength = max($maxLineLength, count($lines[$i]));
        }

        return $maxLineLength;
    }

}