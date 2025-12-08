<?php

declare(strict_types=1);

namespace App\Puzzle\Day08;

class UnionFind {
    public array $parent = [];
    public array $size = [];
    public int $components;

    public function __construct(int $n) {
        $this->parent = range(0, $n - 1);
        $this->size = array_fill(0, $n, 1);
        $this->components = $n;
    }

    public function find(int $x): int {
        if ($this->parent[$x] !== $x) {
            $this->parent[$x] = $this->find($this->parent[$x]);
        }

        return $this->parent[$x];
    }

    public function union(int $a, int $b): void {
        $ra = $this->find($a);
        $rb = $this->find($b);

        if ($ra === $rb) return;

        if ($this->size[$ra] < $this->size[$rb]) {
            [$ra, $rb] = [$rb, $ra];
        }

        $this->parent[$rb] = $ra;
        $this->size[$ra] += $this->size[$rb];

        $this->components--;
    }
}
