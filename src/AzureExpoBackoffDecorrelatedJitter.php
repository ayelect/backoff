<?php

declare(strict_types=1);

namespace Ayelect\Backoff;

/**
 * Inspired by:
 * `https://github.com/Azure/azure-iot-sdk-node/blob/main/common/core/src/retry_policy.ts`
 * `https://github.com/Azure/azure-iot-sdk-java/blob/main/iothub/device/iot-device-client/src/main/java/com/microsoft/azure/sdk/iot/device/transport/ExponentialBackoffWithJitter.java`.
 */
class AzureExpoBackoffDecorrelatedJitter extends AbstractBackoff
{
    /**
     * @var float Jitter down factor
     */
    protected float $jd;

    /**
     * @var float Jitter up factor
     */
    protected float $ju;

    public function __construct(int $base = 1000, int $cap = null, float $jd = 0.5, float $ju = 0.25)
    {
        parent::__construct($base, $cap);

        $this->jd = $jd;
        $this->ju = $ju;
    }

    public function calculate(int $retry): int
    {
        // F(x) = min(Cmin + (2^(x-1)-1) * rand(C*(1–Jd), C*(1-Ju)), Cmax)

        $minRandomFactor = $this->base * (1 - $this->jd);
        $maxRandomFactor = $this->base * (1 - $this->ju);

        $randomJitter = $this->randomInt(0, (int) ($maxRandomFactor - $minRandomFactor - 1));

        // This formula always returns `$this->base` on the first retry
        // since `(2 ** (1 - 1) - 1)` == 0
        // so it's a little bit adjusted (removed `- 1`).
        // $value = ($this->base + (2 ** ($retry - 1) - 1) * $randomJitter);

        $value = ($this->base + (2 ** ($retry - 1)) * $randomJitter);

        return $this->cap($value);
    }
}
