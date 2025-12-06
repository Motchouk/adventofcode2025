<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day6Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Day 6')]
#[Route('/day6', name: 'day6', methods: ['GET'])]
class Day6Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day6Services $day6services
    ){}

    #[Route('/1/{file}', name: 'day6_1', defaults: ["file"=>"day6"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $output = $this->day6services->process($lines, 1);

        return new JsonResponse($output, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day6_2', defaults: ["file"=>"day6"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $output = $this->day6services->process($lines, 2);

        return new JsonResponse($output, Response::HTTP_NOT_ACCEPTABLE);
    }
}
