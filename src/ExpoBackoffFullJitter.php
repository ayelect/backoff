<?php

declare(strict_types=1);

namespace Ayelect\Backoff;

/**
 * Inspired by `https://aws.amazon.com/blogs/architecture/exponential-backoff-and-jitter/`.
 */
class ExpoBackoffFullJitter extends ExpoBackoff
{
    public function calculate(int $retry): int
    {
        $value = parent::calculate($retry);

        return $this->randomInt(0, $value);
    }
}
