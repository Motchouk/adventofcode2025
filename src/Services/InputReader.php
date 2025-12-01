<?php
declare(strict_types=1);

namespace App\Services;

class InputReader
{
    private const EXT = '.txt';

    private $fileDir;

    public function __construct(string $fileDir)
    {
        $this->fileDir = $fileDir;
    }

    public function getInput(string $file): array
    {
        $inputs = [];
        $content = fopen($this->fileDir . $file . self::EXT, 'r');

        while (($line = fgets($content)) !== false) {
            $lineWithoutSpaces = trim($line);
            $inputs[] = $lineWithoutSpaces;
        }

        fclose($content);

        return $inputs;
    }
}
