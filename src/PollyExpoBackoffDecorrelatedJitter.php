<?php

declare(strict_types=1);

namespace Ayelect\Backoff;

/**
 * Inspired by:
 * `https://github.com/Polly-Contrib/Polly.Contrib.WaitAndRetry/blob/master/src/Polly.Contrib.WaitAndRetry/Backoff.DecorrelatedJitterV2.cs`
 * `https://github.com/SocketSomeone/nestjs-resilience/blob/master/src/helpers/decorrelated-jitter.backoff.ts`.
 */
class PollyExpoBackoffDecorrelatedJitter extends AbstractBackoff
{
    protected const RP_SCALING_FACTOR = 1 / 1.4;
    protected const P_FACTOR = 4.0;

    public function calculate(int $retry): int
    {
        throw new \BadMethodCallException('This jitter strategy only supports the Generator approach.');
    }

    public function getGenerator(): \Generator
    {
        $previous = 0;

        for ($retry = 1;; ++$retry) {
            $t = ($retry - 1) + mt_rand() / mt_getrandmax();
            $next = (2 ** $t) * tanh(sqrt(self::P_FACTOR * $t));
            $formulaIntrisincValue = max(0, $next - $previous);

            $previous = $next;

            $value = (int) ($formulaIntrisincValue * self::RP_SCALING_FACTOR * $this->base);

            yield $this->cap($value);
        }
    }
}
