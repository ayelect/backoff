<?php
declare(strict_types=1);

namespace Ayelect\Backoff;

/**
 * Inspired by `https://aws.amazon.com/blogs/architecture/exponential-backoff-and-jitter/`.
 */
class AwsExpoBackoffDecorrelatedJitter extends AbstractBackoff
{
    public function calculate(int $retry): int
    {
        throw new \BadMethodCallException('This jitter strategy only supports the Generator approach.');
    }

    public function getGenerator(): \Generator
    {
        $sleep = $this->base;

        for ($retry = 1;; ++$retry) {
            $sleep = $this->cap($this->randomInt($this->base, $sleep * 3));

            yield $sleep;
        }
    }
}
