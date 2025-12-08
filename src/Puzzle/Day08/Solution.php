<?php

declare(strict_types=1);

namespace App\Puzzle\Day08;

use App\Puzzle\AbstractPuzzle;
use Exception;

class Solution extends AbstractPuzzle
{
    public function solution1(array $input = []): string
    {
        $points = [];
        foreach ($input as $line) {
            $points[] = array_map('intval', explode(',', $line));
        }

        $size = count($input);
        $distances = $this->calculateSortedDistances($points, $size);

        $uf = new UnionFind($size);

        $max = ($size === 20) ? 10 : 1000;
        for ($k = 0; $k < $max; $k++) {
            [$_, $a, $b] = $distances[$k];
            $uf->union($a, $b);
        }

        $componentSizes = [];
        for ($i = 0; $i < $size; $i++) {
            $root = $uf->find($i);
            if (!isset($componentSizes[$root])) {
                $componentSizes[$root] = 0;
            }
            $componentSizes[$root]++;
        }

        rsort($componentSizes);
        return (string) ($componentSizes[0] * $componentSizes[1] * $componentSizes[2]);
    }

    public function solution2(array $input = []): string
    {
        $points = [];
        foreach ($input as $line) {
            $points[] = array_map('intval', explode(',', $line));
        }

        $size = count($input);
        $uf = new UnionFind($size);

        $distances = $this->calculateSortedDistances($points, $size);
        foreach ($distances as [$_, $a, $b]) {
            $uf->union($a, $b);

            if ($uf->components === 1) {
                $ax = $points[$a][0];
                $bx = $points[$b][0];
                return (string) ($ax * $bx);
            }
        }

        throw new Exception("Unexpected: graph never fully connects");
    }

    private function calculateSortedDistances(array $points, int $size): array
    {
        $distances = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = $i + 1; $j < $size; $j++) {
                [$x1, $y1, $z1] = $points[$i];
                [$x2, $y2, $z2] = $points[$j];

                $dx = $x1 - $x2;
                $dy = $y1 - $y2;
                $dz = $z1 - $z2;

                $euclideanDistance =  $dx*$dx + $dy*$dy + $dz*$dz;

                $distances[] = [$euclideanDistance, $i, $j];
            }
        }

        sort($distances);
        return $distances;
    }
}
