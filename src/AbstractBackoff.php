<?php
declare(strict_types=1);

namespace Ayelect\Backoff;

abstract class AbstractBackoff
{
    protected int $base;
    protected ?int $cap;

    public function __construct(int $base = 1000, int $cap = null)
    {
        $this->base = $base;
        $this->cap = $cap;
    }

    abstract public function calculate(int $retry): int;

    public function getGenerator(): \Generator
    {
        for ($retry = 1;; ++$retry) {
            yield $this->calculate($retry);
        }
    }

    protected function cap(int $value): int
    {
        return $this->cap !== null ? min($this->cap, $value) : $value;
    }

    protected function randomInt(int $min, int $max): int
    {
        try {
            return random_int($min, $max);
        } catch (\Exception) {
            return mt_rand($min, $max);
        }
    }

    protected function randomFloat(): float
    {
        $max = mt_getrandmax();

        return $this->randomInt(0, $max - 1) / $max;
    }
}
