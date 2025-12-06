<?php

declare(strict_types=1);

namespace App\Puzzle\Day06;

use App\Puzzle\AbstractPuzzle;
use InvalidArgumentException;

class Solution extends AbstractPuzzle
{
    public function solution1(array $input = []): string
    {
        $combined = [];
        foreach ($input as $line) {
            $column = 0;
            $split = explode(" ", $line);

            foreach ($split as $part) {
                if ($part !== '') {
                    $combined[$column][] = $part;
                    $column++;
                }
            }
        }

        return (string) $this->sumAll($combined);
    }

    public function solution2(array $input = []): string
    {
        $maxWidth = max(array_map('strlen', $input));

        $grid = [];
        foreach ($input as $y => $line) {
            $line = str_pad($line, $maxWidth);

            for ($x = 0; $x < $maxWidth; $x++) {
                $grid[$y][$x] = $line[$x];
            }
        }

        $operators = array_pop($grid);
        $operators = array_filter($operators, fn(string $operator) => trim($operator) !== '');

        $columns = [];
        for ($i = 0; $i < $maxWidth; $i++) {
            $columns[] = array_column($grid, $i);
        }

        $merged = [];
        $counter = 0;
        foreach ($columns as $column) {
            $current = implode('', $column);

            if (trim($current) !== '') {
                $merged[$counter][] = $current;
            } else {
                $merged[$counter][] = array_shift($operators);
                $counter++;
            }
        }

        $merged[$counter][] = array_shift($operators);

        return (string) $this->sumAll($merged);
    }

    private function sumAll(array $combined): int
    {
        $sum = 0;
        foreach ($combined as $parts) {
            $operator = array_pop($parts);

            $sum += array_reduce($parts, function(int $carry, string $item) use ($operator) {
                $item = intval($item);

                if ($carry === 0) {
                    return $item;
                }

                return match ($operator) {
                    '+' => $carry + $item,
                    '*' => $carry * $item,
                    default => throw new InvalidArgumentException("Unsupported operator: $operator"),
                };
            }, 0);
        }

        return $sum;
    }
}
