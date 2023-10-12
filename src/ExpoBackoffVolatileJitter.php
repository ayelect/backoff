<?php

declare(strict_types=1);

namespace Ayelect\Backoff;

class ExpoBackoffVolatileJitter extends ExpoBackoff
{
    protected float $volatility;

    public function __construct(float $volatility = 0.1, int $base = 1000, int $cap = null)
    {
        if ($volatility < 0 || $volatility > 1) {
            throw new \InvalidArgumentException('Volatility must be between 0.0 and 1.0');
        }

        parent::__construct($base, $cap);

        $this->volatility = $volatility;
    }

    public function calculate(int $retry): int
    {
        $value = parent::calculate($retry);

        return $this->randomInt((int) ($value * (1 - $this->volatility)), (int) ($value * (1 + $this->volatility)));
    }
}
