<?php

declare(strict_types=1);

namespace App\Puzzle\Day03;

use App\Puzzle\AbstractPuzzle;

class Solution extends AbstractPuzzle
{
    public function solution1(array $input = []): string
    {
        $sum = 0;
        foreach ($input as $line) {
            $sum += (int) $this->maxAfterRemovingDigitCount($line, strlen($line) - 2);
        }

        return (string) $sum;
    }

    public function solution2(array $input = []): string
    {
        $sum = 0;
        foreach ($input as $line) {
            $sum += (int) $this->maxAfterRemovingDigitCount($line, strlen($line) - 12);
        }

        return (string) $sum;
    }

    private function maxAfterRemovingDigitCount(string $input, int $digitCount): string
    {
        $stack = [];
        foreach (str_split($input) as $d) {
            while ($digitCount > 0 && $stack && end($stack) < $d) {
                array_pop($stack);
                $digitCount--;
            }

            $stack[] = $d;
        }

        if ($digitCount > 0) {
            $stack = array_slice($stack, 0, count($stack) - $digitCount);
        }

        return implode('', $stack);
    }
}
