<?php

namespace App\Services;

class Day9Services
{
    private array $coordinates = [];
    private int $result = 0;

    public function __construct(
        private readonly CalendarServices $calendarServices
    ) {}

    public function process(array $lines, int $part): int
    {
        // turns into a proper coordinates list.
        $this->coordinates = $this->calendarServices->parseInputWithIntegersAndComma($lines);
        // trie des coordonnées par ordre "croissant"
        usort($this->coordinates, function ($coord1, $coord2) {
            if ($coord1[0] === $coord2[0]) {
                return $coord1[1] - $coord2[1];
            }

            return $coord1[0] - $coord2[0];
        });

        if (1 === $part) {
            $this->findBiggestRectangle();
        }

        return $this->result;
    }

    private function findBiggestRectangle(): void
    {
        $pointer1 = 0;
        $pointer2 = 1;

        while ($pointer1 !== $pointer2) {
            for ($pointer2 = $pointer1 + 1; $pointer2 < \count($this->coordinates); $pointer2++) {
                if ($this->isRectangle($this->coordinates[$pointer1], $this->coordinates[$pointer2])) {
                    $this->result = max ($this->result, $this->calculateAreaFromDiagonalCoords($this->coordinates[$pointer1], $this->coordinates[$pointer2]));
                }
            }

            $pointer1++;
        }
    }

    private function calculateAreaFromDiagonalCoords(array $coordinates1, array $coordinates2): int
    {
        $surface = ((max($coordinates1[0],$coordinates2[0]) - min($coordinates1[0],$coordinates2[0])) + 1)
            * ((max($coordinates1[1],$coordinates2[1]) - min($coordinates1[1],$coordinates2[1])) + 1);

//        dump(sprintf('Surface %s %s : ((%d - %d) + 1) x ((%d - %d) + 1) = %d ',
//            json_encode($coordinates1),
//            json_encode($coordinates2),
//            max($coordinates1[0],$coordinates2[0]),
//            min($coordinates1[0],$coordinates2[0]),
//            max($coordinates1[1],$coordinates2[1]),
//            min($coordinates1[1],$coordinates2[1]),
//            $surface));

        return $surface;
    }

    private function isRectangle(array $coordinate1, array $coordinate2): bool
    {
        return ($coordinate1[0] !== $coordinate2[0]) && ($coordinate1[1] !== $coordinate2[1]);
    }
}