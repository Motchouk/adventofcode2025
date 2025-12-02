<?php

namespace App\Services;

class Day2Services
{
    public function countRepeatedNumbers(string $range, int &$total, bool $equalParts = true): void
    {
        $rangesValues = explode('-', $range);

        for ($i = (int)$rangesValues[0]; $i <= (int)$rangesValues[1]; $i++) {
            $currentValue = (string)$i;
            if ($equalParts) { // we search for equal patterns i.e 12341234 or 99
                $length = strlen($currentValue) / 2;
                $regex = '#(\d{'.$length.'})\1+#';
            } else { // we search for any repetitive pattern i.e 121212 or 999
               $regex = '#(^\d+)\1{1,}$#';
            }

            if (preg_match($regex, $currentValue)) {
                $total+= $i;
            }
        }
    }
}
