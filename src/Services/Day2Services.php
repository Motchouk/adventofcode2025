<?php

namespace App\Services;

class Day2Services
{
    private int $invalidIds = 0;
    private int $invalidIdsSum = 0;

    private array $repeatedSequences = [];

    private int $repeatedSequencesSum = 0;

    public function process(string $content, int $part): int
    {
        $ranges = $this->getRanges($content);

        foreach ($ranges as $range) {
            $this->findInvalidIds($range);
        }

        if (1 === $part) {
            return $this->invalidIdsSum;
        }

        return $this->repeatedSequencesSum;
    }

    private function findInvalidIds(array $range): void
    {
        [$min, $max] = $range;
        $stringifiedNum = '';

        for ($i = $min; $i <= $max; $i++) {
            $stringifiedNum = (string) $i;

            if (str_starts_with($stringifiedNum, '0')) {
                continue;
            }

            // Part 1
            if ($this->hasRepeatedSequence($stringifiedNum)) {
                $this->invalidIds++;
                $this->invalidIdsSum += $i;
            }

            // Part 2
            if ($this->hasRepeatedPattern($stringifiedNum)) {
                $this->repeatedSequences[] = $i;
                $this->repeatedSequencesSum += $i;
            }
        }
    }

    private function hasRepeatedSequence(string $number): bool
    {
        // Impair numbers cannont be a repeated sequence
        if (1 === (strlen($number) % 2)) {
            return false;
        }

        $numberAsArray = str_split($number);

        // Numbers of two chars are fastest to verify
        if (2 === strlen($number)) {
            return $numberAsArray[0] === $numberAsArray[1];
        }

        $startPointer = 0;
        $limit = $midPointer = intdiv(strlen($number), 2);

        while ($startPointer < $limit) {
            if ($numberAsArray[$startPointer] !== $numberAsArray[$midPointer]) {
                return false;
            }

            $startPointer++;
            $midPointer++;
        }

        return true;
    }

    private function getRanges(string $content): array
    {
        $ranges = [];

        preg_match_all('/([0-9]{1,}-[0-9]{1,})/', $content, $matches);

        foreach ($matches[1] as $match) {
            $ranges[] = explode('-', $match);
        }

        return $ranges;
    }

    private function hasRepeatedPattern(string $number): bool
    {
        return 1 === preg_match('/^(\d+)\1+$/', $number);
    }
}