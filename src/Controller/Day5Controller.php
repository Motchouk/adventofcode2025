<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day5Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Day 5')]
#[Route('/day5', name: 'day5', methods: ['GET'])]
class Day5Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day5Services $day5services
    ){}

    #[Route('/1/{file}', name: 'day5_1', defaults: ["file"=>"day5"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $output = $this->day5services->process($lines, 1);

        return new JsonResponse($output, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day5_2', defaults: ["file"=>"day5"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $output = $this->day5services->process($lines, 2);

        return new JsonResponse($output, Response::HTTP_NOT_ACCEPTABLE);
    }
}
