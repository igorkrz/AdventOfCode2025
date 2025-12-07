<?php

declare(strict_types=1);

namespace App\Puzzle\Day07;

use App\Puzzle\AbstractPuzzle;

class Solution extends AbstractPuzzle
{
    public function solution1(array $input = []): string
    {
        $height = count($input);

        $startingPoint = null;
        foreach ($input as $y => $line) {
            if (str_contains($line, 'S')) {
                $startingPoint = [strpos($line, 'S'), $y];
                break;
            }
        }

        $queue = [[$startingPoint[0], $startingPoint[1] + 1]];
        $visited = [];
        $sum = 0;
        while ($queue) {
            [$x, $y] = array_pop($queue);

            if ($y >= $height) {
                continue;
            }

            $key = "$x,$y";
            if (isset($visited[$key])) {
                continue;
            }

            $visited[$key] = true;

            $cell = $input[$y][$x];
            switch ($cell) {
                case '^':
                    $sum++;

                    $queue[] = [$x - 1, $y + 1];
                    $queue[] = [$x + 1, $y + 1];
                    break;
                default:
                    $queue[] = [$x, $y + 1];
                    break;
            }
        }

        return (string) $sum;
    }

    public function solution2(array $input = []): string
    {
        $height = count($input);

        $startingPoint = null;
        foreach ($input as $y => $line) {
            if (str_contains($line, 'S')) {
                $startingPoint = [strpos($line, 'S'), $y];
                break;
            }
        }

        $startX = $startingPoint[0];
        $startY = $startingPoint[1];
        $current = [$startX => 1];
        for ($y = $startY + 1; $y < $height; $y++) {
            $next = [];
            foreach ($current as $x => $count) {
                $cell = $input[$y][$x];

                switch ($cell) {
                    case '^':
                        $next[$x - 1] = ($next[$x - 1] ?? 0) + $count;
                        $next[$x + 1] = ($next[$x + 1] ?? 0) + $count;
                        break;
                    default:
                        $next[$x] = ($next[$x] ?? 0) + $count;
                        break;
                }
            }

            $current = $next;
        }

        return (string) array_sum($current);
    }
}
