<?php

namespace App\Services;

class Day4Services
{
    private const LIMIT = 4;
    private array $grid;

    private int $removed = 0;

    public function __construct(
        private readonly CalendarServices $calendarServices
    ) {}

    public function process(array $lines, int $part = 1): int
    {
       $this->grid = $this->calendarServices->parseInputFromStringsToArray($lines);
       $result = 0;

       if (1 === $part) {
           $result = $this->convertGridAdjacentWeigth();
       }

       if (2 === $part) {
           $canBeRemoved = $this->convertGridAdjacentWeigth();
           dump($this->grid);


           while ($canBeRemoved !== 0)
           {
               $result += $canBeRemoved;
               $this->remove();
               $canBeRemoved = $this->convertGridAdjacentWeigth();
           }
       }

       return $result;
    }

    private function convertGridAdjacentWeigth(): int
    {
        $result = 0;

        for ($line = 0; $line < count($this->grid); $line++) {
            for ($column = 0; $column < count($this->grid[0]); $column++) {
                if ('.' !== $this->grid[$line][$column]) {
                    $value = $this->convert($line, $column);

                    if ($value < self::LIMIT) {
                        $result++;
                    }
                }
            }
        }

        return $result;
    }

    private function convert(int $line, int $column): int
    {
        $value = 0;

        $coords = [
            [$line - 1, $column - 1],
            [$line - 1, $column],
            [$line - 1, $column + 1],
            [$line, $column - 1],
            [$line, $column + 1],
            [$line + 1, $column - 1],
            [$line + 1, $column],
            [$line + 1, $column + 1],
        ];

        foreach ($coords as [$checkLine, $checkColumn]) {
            if (isset($this->grid[$checkLine][$checkColumn]) && '.' !== $this->grid[$checkLine][$checkColumn]) {
                ++$value;
            }
        }

        $this->grid[$line][$column] = $value;

        return $value;
    }

    private function remove(): void
    {
        for ($line = 0; $line < count($this->grid); $line++) {
            for ($column = 0; $column < count($this->grid[0]); $column++) {
                if (('.' !== $this->grid[$line][$column])
                    && ($this->grid[$line][$column] < self::LIMIT)
                ) {
                    ++$this->removed;
                    $this->grid[$line][$column] = '.';
                }
            }
        }
    }
}