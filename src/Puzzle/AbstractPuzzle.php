<?php

declare(strict_types=1);

namespace App\Puzzle;

use ReflectionClass;

abstract class AbstractPuzzle
{
    private float $ini_time;

    public function __construct()
    {
        $this->ini_time = microtime(true) * 1000;
    }

    public function read(): array
    {
        return (array) file($this->getInputFilePath(), FILE_IGNORE_NEW_LINES);
    }

    public function write(string $string): void
    {
        echo "\nResult: \e[0;30;42m " . $string . " \e[0m\n\n";

        echo 'Time: ' . ((microtime(true) * 1000) - $this->ini_time) . "\n";
    }

    protected function getInputFilePath(): string
    {
        $path = (string) new ReflectionClass($this)->getFileName();

        $name = new ReflectionClass($this)->getShortName();

        return str_replace($name.'.php', 'input.txt', $path);
    }
}
