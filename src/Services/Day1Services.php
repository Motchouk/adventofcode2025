<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class Day1Services
{
    private const START_POSITION = 50;

    public function __construct(
        private InputReader $inputReader,
    ) {}

    public function process1(string $file): int
    {
        $input = $this->inputReader->getInput($file);
        $wentOnZero = 0;
        $stoppedOnZero = 0;
        $cursorPosition = self::START_POSITION;

        foreach ($input as $line) {
            preg_match('/^([LR])([0-9]{1,})$/', $line, $matches);

            if ('R' === $matches[1]) {
                $this->add((int) $matches[2], $cursorPosition, $wentOnZero);

                if (0 === $cursorPosition) {
                    ++$stoppedOnZero;
                    ++$wentOnZero;
                }

                continue;
            }

            $this->substract((int) $matches[2], $cursorPosition, $wentOnZero);

            if (0 === $cursorPosition) {
                ++$stoppedOnZero;
                ++$wentOnZero;
            }
        }

        // Part 1
        // return $stoppedOnZero;

        // Part 2
        return $wentOnZero;
    }

    private function add(int $number, int &$cursorPosition, int &$wentOnZero): void
    {
        $wentOnZero += intdiv($number, 100);

        $number = $number % 100;
        $cursorPosition += $number;

        if ($cursorPosition > 100) {
            ++$wentOnZero;
        }

        $cursorPosition = $cursorPosition % 100;
    }

    private function substract(int $number, int &$cursorPosition, int &$wentOnZero): void
    {
        $startAtZero = 0 === $cursorPosition;
        $wentOnZero += intdiv(abs($number), 100);

        $cursorPosition -= abs($number) % 100;

        if ($cursorPosition < 0) {
            if (false === $startAtZero) {
                ++$wentOnZero;
            }

            $cursorPosition += 100;
        }
    }
}
