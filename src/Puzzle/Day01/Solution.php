<?php

declare(strict_types=1);

namespace App\Puzzle\Day01;

use App\Puzzle\AbstractPuzzle;
use Exception;

class Solution extends AbstractPuzzle
{
    public function solution1(array $input = []): string
    {
        $start = 50;
        $sum = 0;

        foreach ($input as $line) {
            $value = (int) substr($line, 1);

            $start = match ($line[0]) {
                'L' => ($start - $value) % 100,
                'R' => ($start + $value) % 100,
                default => throw new Exception('Invalid direction'),
            };

            if ($start === 0) {
                $sum++;
            }
        }

        return (string) $sum;
    }

    public function solution2(array $input = []): string
    {
        $start = 50;
        $sum = 0;

        foreach ($input as $line) {
            $value = (int) substr($line, 1);

            $direction = match ($line[0]) {
                'L' => -1,
                'R' => 1,
                default => throw new Exception('Invalid direction'),
            };

            $sum += intdiv(abs($start + $value * $direction), 100);

            if ($direction === -1 && $start !== 0 && $value >= $start) {
                $sum++;
            }

            $start = ($start + $direction * $value) % 100;

            if ($start < 0) {
                $start += 100;
            }
        }

        return (string) $sum;
    }
}
