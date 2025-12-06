<?php

namespace App\Services;

use App\Services\Helper\ArrayRangeMerger;

class Day5Services
{
    private array $ranges = [];
    private array $ids =  [];

    private int $freshProductCount = 0;

    public function process(array $lines, int $part): int
    {
        $this->splitRangesAndIds($lines);
        dump($this->ranges);

       if (1 === $part) {
           $this->countFreshProducts();

           return $this->freshProductCount;
       }

        return 0;
    }

    private function splitRangesAndIds(array $lines): void
    {
        foreach ($lines as $line) {
            if (1 === preg_match('/^\d+-\d+$/', $line, $matches)) {
                [$min, $max] = explode('-', $matches[0]);

                $this->addRange($min, $max);

                continue;
            }

            if (1 === preg_match('/^\d+$/', $line)) {
                $this->ids[] = $line;
            }
        }
    }

    private function addRange(int $min, int $max): null
    {
//        $updatedRangeIndex = $this->mergeRange($min, $max);
//
//        // Si fusion, vérifier si des nouvelles fusions sont possibles
//        if (null !== $updatedRangeIndex) {
//            [$min, $max] = $this->ranges[$updatedRangeIndex];
//            array_splice($this->ranges, $updatedRangeIndex, 1);
//
//            return $this->addRange($min, $max);
//        }

        // Sinon ajout simple
        $this->ranges[] = [$min,$max];

        return null;
    }

    private function mergeRange(int $min, int $max): ?int
    {
        if (empty($this->ranges)) {
            return null;
        }

        for ($index = 0; $index < count($this->ranges); $index++) {
            [$rangeMin, $rangeMax] = $this->ranges[$index];

            // SKIP : min et max ne sont pas dans range
            if ($max < $rangeMin || $min > $rangeMax) {
                continue;
            }

            // CAS 1 : la range englobe la range précédente
            if ($min < $rangeMin && $max > $rangeMax) {
                $this->ranges[$index] = [$min, $max];

                return $index;
            }

            // CAS 2 : la range allonge la taille par le bas
            if ($min < $rangeMin && $rangeMin <= $max && $max <= $rangeMax) {
                $this->ranges[$index] = [min($min, $rangeMin), max($max, $rangeMax)];

                return $index;
            }

            // CAS 3 : la range allonge la taille par le haut
            if ($rangeMin <= $min && $min <= $rangeMax && $rangeMax < $max) {
                $this->ranges[$index] = [min($min, $rangeMin), max($max, $rangeMax)];

                return $index;
            }
        }

        return null;
    }



    private function countFreshProducts()
    {
        foreach ($this->ids as $id) {
            foreach ($this->ranges as [$min, $max]) {
                if ($min <= $id && $id <= $max) {
                    ++$this->freshProductCount;
                    break;
                }
            }
        }
    }
}