<?php

declare(strict_types=1);

namespace App\Puzzle\Day02;

use App\Puzzle\AbstractPuzzle;

class Solution extends AbstractPuzzle
{
    public function solution1(array $input = []): string
    {
        $regexPattern = '#^([1-9]\d*?)\1$#';
        $invalidIds = $this->getInvalidIds($input, $regexPattern);

        return (string) array_sum($invalidIds);
    }

    public function solution2(array $input = []): string
    {
        $regexPattern = '#^([1-9]\d*?)\1+$#';
        $invalidIds = $this->getInvalidIds($input, $regexPattern);

        return (string) array_sum($invalidIds);
    }

    private function getInvalidIds(array $input, string $regexPattern): array
    {
        $ranges = explode(',', $input[0]);
        $invalidIds = [];

        foreach ($ranges as $range) {
            $splitRange = explode('-', $range);
            $range = range($splitRange[0], $splitRange[1]);

            $matches = preg_grep($regexPattern, $range);
            foreach ($matches as $match) {
                $invalidIds[] = $match;
            }
        }

        return $invalidIds;
    }
}
