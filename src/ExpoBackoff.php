<?php
declare(strict_types=1);

namespace Ayelect\Backoff;

class ExpoBackoff extends AbstractBackoff
{
    public function calculate(int $retry): int
    {
        return $this->cap((2 ** ($retry - 1)) * $this->base);
    }
}
