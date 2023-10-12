<?php

declare(strict_types=1);

namespace Ayelect\Backoff;

/**
 * Inspired by `https://aws.amazon.com/blogs/architecture/exponential-backoff-and-jitter/`.
 */
class ExpoBackoffEqualJitter extends ExpoBackoff
{
    public function calculate(int $retry): int
    {
        $value = parent::calculate($retry);
        $half = $value / 2;

        return (int) ($half + $this->randomInt(0, $half));
    }
}
