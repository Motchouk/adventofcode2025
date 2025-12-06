<?php
declare(strict_types=1);

namespace App\Services;

class InputReader
{
    private $fileDir;

    public function __construct(string $fileDir)
    {
        $this->fileDir = $fileDir;
    }

    public function getInput(string $file, ?bool $trim = true): array
    {
        $inputs = [];
        $content = fopen($this->fileDir . $file, 'r');

        while (($line = fgets($content)) !== false) {
            if ($trim) {
                $line = trim($line);
            }
            else {
                $line = preg_replace("/[\n\r]/", "", $line);
            }

            $inputs[] = $line;
        }

        fclose($content);

        return $inputs;
    }

    public function getRawInput(string $file): string
    {
        return file_get_contents($this->fileDir . $file);
    }
}
