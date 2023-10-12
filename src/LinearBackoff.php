<?php
declare(strict_types=1);

namespace Ayelect\Backoff;

class LinearBackoff extends AbstractBackoff
{
    public function calculate(int $retry): int
    {
        return $this->cap($this->base * $retry);
    }
}
