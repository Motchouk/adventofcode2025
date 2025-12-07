<?php

namespace App\Services;

class Day7Services
{
    private array $hasSplittedPosition = [];
    private array $lines = [];
    private int $result = 0;

    public function __construct(
        private readonly CalendarServices $calendarServices
    ) {}

    public function process(array $lines, int $part): int
    {
        $this->lines = $this->calendarServices->parseInputFromStringsToArray($lines);

        if (1 === $part) {
            $this->beam($lines);
        }

        return $this->result;
    }

    private function beam(array $lines): void
    {
        $penultimate = count($this->lines) - 1;
        $columns = count($this->lines[0]);

        // On s'arrête à l'avant-dernière ligne
        for ($line = 0; $line < $penultimate; $line++) {
            for ($column = 0; $column < $columns; $column++) {
                if (('|' === $this->lines[$line][$column])
                || 'S' === $this->lines[$line][$column]) {
                    $this->beamDown($line, $column);
                }
            }

            // No need to stock previous coordinates, makes in_array faster
            $this->hasSplittedPosition = [];
//            $this->displayGrid();
        }
    }

    private function beamDown(int $line, int $column): void
    {
        if ('^' === $this->lines[$line+1][$column]) {
            $plitCoords = sprintf('[%d,%d]', $line, $column);

            if (false === \in_array($plitCoords, $this->hasSplittedPosition)) {
                $this->result++;
                $this->hasSplittedPosition[] = $plitCoords;
            }

            $this->splitBeam($line+1, $column);

            return;
        }

        $this->lines[$line+1][$column] = '|';
    }

    private function splitBeam(int $line, int $column): void
    {
        if (isset($this->lines[$line][$column-1]) && ('|' !== $this->lines[$line][$column-1])) {
            $this->lines[$line][$column-1] = '|';
        }

        if (isset($this->lines[$line][$column+1]) && ('|' !== $this->lines[$line][$column+1])) {
            $this->lines[$line][$column+1] = '|';
        }
    }

    private function displayGrid(): void
    {
        $grid = [];
        foreach ($this->lines as $line) {
            $grid[] = json_encode($line);
        }

        dump($grid);
    }
}