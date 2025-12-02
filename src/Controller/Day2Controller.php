<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day2Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Day 2')]
#[Route('/day2', name: 'day2', methods: ['GET'])]
class Day2Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day2Services $day2services
    ){}

    #[Route('/1/{file}', name: 'day2_1', defaults: ["file"=>"day2"])]
    public function part1(string $file): JsonResponse
    {
        $content = $this->inputReader->getRawInput($file.'.txt');
        $output = $this->day2services->process($content);

        return new JsonResponse($output, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day2_2', defaults: ["file"=>"day2"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
