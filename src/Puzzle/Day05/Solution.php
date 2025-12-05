<?php

declare(strict_types=1);

namespace App\Puzzle\Day05;

use App\Puzzle\AbstractPuzzle;

class Solution extends AbstractPuzzle
{
    public function solution1(array $input = []): string
    {
        $sum = 0;
        $ranges = [];
        $ingredients = [];

        foreach ($input as $line) {
            $split = explode("-", $line);
            if (count($split) === 2) {
                $ranges[] = [intval($split[0]), intval($split[1])];
            }

            if (count($split) === 1 && $split[0] !== '') {
                $ingredients[intval($split[0])] = false;
            }
        }

        foreach ($ingredients as $ingredientId => $isFresh) {
            foreach ($ranges as $range) {
                if ($ingredients[$ingredientId]) {
                    continue;
                }


                if ($ingredientId >= $range[0] && $ingredientId <= $range[1]) {
                    $ingredients[$ingredientId] = true;
                    $sum++;
                }
            }
        }

        return (string) $sum;
    }

    public function solution2(array $input = []): string
    {
        $sum = 0;
        $ranges = [];
//        $ingredients = [];

        foreach ($input as $line) {
            $split = explode("-", $line);
            if (count($split) === 2) {
                $ranges[] = [intval($split[0]), intval($split[1]), false];
            }

//            if (count($split) === 1 && $split[0] !== '') {
//                $ingredients[intval($split[0])] = false;
//            }
        }

        // This might be an error in the solution because we don't actually check which ones are fresh, we are taking
        // everything into consideration, or maybe I just misunderstood the puzzle, anyway here is the working code if
        // we are only searching for fresh ingredients

//        foreach ($ingredients as $ingredientId => $isFresh) {
//            foreach ($ranges as $key => $range) {
//                if ($range[2]) {
//                    continue;
//                }
//
//                if ($ingredientId >= $range[0] && $ingredientId <= $range[1]) {
//                    $ranges[$key][2] = true;
//                }
//            }
//        }
//        $ranges = array_filter($ranges, fn($r) => $r[2]);

        usort($ranges, function($x, $y){
            if ($x[0] === $y[0]) {
                return $x[1] <=> $y[1];
            }

            return $x[0] <=> $y[0];
        });

        $currentStart = $ranges[0][0];
        $currentEnd = $ranges[0][1];
        foreach ($ranges as [$start, $end]) {
            if ($start <= $currentEnd + 1) {
                $currentEnd = max($currentEnd, $end);
                continue;
            }

            $sum += $currentEnd - $currentStart + 1;
            $currentStart = $start;
            $currentEnd = $end;
        }

        if ($currentStart !== null) {
            $sum += ($currentEnd - $currentStart + 1);
        }

        return (string) $sum;
    }
}
