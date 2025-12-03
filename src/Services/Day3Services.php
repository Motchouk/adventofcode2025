<?php

namespace App\Services;

class Day3Services
{
    private const JOIN_SIZE = 12;
    private int $maxVoltage = 0;
    private int $maxVoltageFirstDigit = 0;

    public function process(array $lines, int $part): int
    {
        foreach ($lines as $line) {
            if (1 === $part) {
                $this->getMaxVoltage(str_split($line));

                continue;
            }

            $this->getMaxVolateJoint(str_split($line));
        }

        return $this->maxVoltage;
    }

    private function getMaxVoltage(array $line): void
    {
        $leftPointer = 0;
        $rightPointer = 1;
        $maxVoltage = 0;
        $length = count($line) - 1;
        $this->maxVoltageFirstDigit = 0;

        while ($leftPointer < $length) {
            if ($line[$leftPointer] < $this->maxVoltageFirstDigit) {
                $leftPointer++;
                $rightPointer = $leftPointer+1;
                continue;
            }

            $number = (int) $line[$leftPointer].$line[$rightPointer];

            if ($number > $maxVoltage) {
                $maxVoltage = $number;
                $this->maxVoltageFirstDigit = $line[$leftPointer];
            }

            ++$rightPointer;

            if ($rightPointer >= $length + 1) {
                ++$leftPointer;
                $rightPointer = $leftPointer+1;
            }
        }

        $this->maxVoltage += $maxVoltage;
    }

    private function getMaxVolateJoint(array $line): void
    {
        $currentIndex = 0;
        $maxDigitPointer = count($line) - self::JOIN_SIZE + $currentIndex;
        $biggestNumber = '';

        while(strlen($biggestNumber) < self::JOIN_SIZE) {
            [$nextDigit,$nextDigitIndex] = $this->getNextMaxVoltageDigit($line, $currentIndex, $maxDigitPointer);
            $biggestNumber .= $nextDigit;
            $currentIndex = $nextDigitIndex+1;
            ++$maxDigitPointer;
        }

        $this->maxVoltage += (int) $biggestNumber;
    }

    private function getNextMaxVoltageDigit($line, $index, $indexLimit): array
    {
        $max = $maxIndex = 0;

        for ($i = $index; $i <= $indexLimit; $i++) {
            if ($max < $line[$i]) {
                $max = $line[$i];
                $maxIndex = $i;
            }
        }

        return [$max, $maxIndex];
    }
}