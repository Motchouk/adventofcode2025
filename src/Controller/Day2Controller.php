<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day2Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/day2', name: 'day2')]
class Day2Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day2Services $day2services,
        private CalendarServices $calendarServices
    ){}

    #[Route('/1/{file}', name: 'day2_1', defaults: ["file"=>"day2"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $ranges = $this->calendarServices->parseInputWithComma($lines)[0];
        $total = 0;
        foreach ($ranges as $range) {
            $this->day2services->countRepeatedNumbers($range, $total);
        }

        return new JsonResponse($total, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day2_2', defaults: ["file"=>"day2"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $ranges = $this->calendarServices->parseInputWithComma($lines)[0];
        $total = 0;
        foreach ($ranges as $range) {
            $this->day2services->countRepeatedNumbers($range, $total, false);
        }

        return new JsonResponse($total, Response::HTTP_OK);
    }
}
