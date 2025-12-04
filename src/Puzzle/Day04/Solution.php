<?php

declare(strict_types=1);

namespace App\Puzzle\Day04;

use App\Puzzle\AbstractPuzzle;

class Solution extends AbstractPuzzle
{
    public function solution1(array $input = []): string
    {
        $grid = $this->createGrid($input);
        return (string) $this->checkAdjacent($grid);
    }

    public function solution2(array $input = []): string
    {
        $sum = 0;
        $grid = $this->createGrid($input);

        do {
            $start = $sum;
            $sum += $this->checkAdjacent($grid, true);
        } while ($sum > $start);

        return (string) $sum;
    }

    private function createGrid(array $input): array
    {
        $grid = [];
        foreach ($input as $row => $line) {
            foreach (str_split($line) as $col => $char) {
                $grid[$row][$col] = $char;
            }
        }

        return $grid;
    }

    private function checkAdjacent(array &$grid, bool $shouldRemove = false): int
    {
        $sum = 0;
        $directions = [[-1, -1], [-1, 0], [-1, 1], [0, -1], [0, 1], [1, -1], [1, 0], [1, 1]];
        $paperRoll = '@';
        $removedPaperRoll = '.';

        foreach ($grid as $row => $line) {
            foreach ($line as $col => $char) {
                if ($char !== $paperRoll) {
                    continue;
                }

                $adjacent = 0;

                foreach ($directions as $direction) {
                    if (isset($grid[$row + $direction[0]][$col + $direction[1]]) && $grid[$row + $direction[0]][$col + $direction[1]] === $paperRoll) {
                        $adjacent++;
                    }
                }

                if ($adjacent < 4) {
                    $sum++;
                    if ($shouldRemove) {
                        $grid[$row][$col] = $removedPaperRoll;
                    }
                }
            }
        }

        return $sum;
    }
}
