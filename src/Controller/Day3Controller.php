<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day3Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Day 3')]
#[Route('/day3', name: 'day3', methods: ['GET'])]
class Day3Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day3Services $day3services
    ){}

    #[Route('/1/{file}', name: 'day3_1', defaults: ["file"=>"day3"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $output = $this->day3services->process($lines, 1);

        return new JsonResponse($output, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day3_2', defaults: ["file"=>"day3"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $output = $this->day3services->process($lines, 2);

        return new JsonResponse($output, Response::HTTP_NOT_ACCEPTABLE);
    }
}
