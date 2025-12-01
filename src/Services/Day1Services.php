<?php

declare(strict_types=1);

namespace App\Services;

class Day1Services
{
    public const MAX = 100;
    public const MIN = 0;

    public function getNewPositionAnd0Pointers(string $line, int $currentPos): array
    {
        $distance = (int) substr($line, 1);
        if (str_starts_with($line, 'R')) {
            $newPositionAndZeros = $this->getRightPositionAndEncounteredZeros($currentPos, $distance);
            $numberOfZeros = floor($distance / 100) + $newPositionAndZeros[1];
        } else {
            $newPositionAndZeros = $this->getLeftPositionAndEncounteredZeros($currentPos, $distance);
            $numberOfZeros = floor($distance / 100) + $newPositionAndZeros[1];
        }

        return [$newPositionAndZeros[0], $numberOfZeros];
    }

    public function getRightPositionAndEncounteredZeros(int $currentPos, int $length): array
    {
        $virtualPos = $currentPos + ($length % 100);
        $zeros = 0;

        if (self::MAX <= $virtualPos) {
            // if old pos is 0 OR if new one is 100, then we are NOT passing 0
            if (self::MIN !== $currentPos && self::MAX !== $virtualPos) {
                $zeros = 1;
            }

            $virtualPos = $virtualPos - self::MAX;
        }

        return [$virtualPos, $zeros];
    }

    public function getLeftPositionAndEncounteredZeros(int $currentPos, int $length): array
    {
        $zeros = 0;
        $virtualPos = $currentPos - ($length % 100);

        if ($virtualPos < self::MIN) {
            // if old position is 0 then we are NOT passing the 0 value
            if (self::MIN !== $currentPos) {
                $zeros = 1;
            }

            $virtualPos = (self::MAX + $virtualPos);
        }

        return [$virtualPos, $zeros];
    }
}
