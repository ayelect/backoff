<?php
declare(strict_types=1);

namespace Ayelect\Backoff;

class ConstantBackoff extends AbstractBackoff
{
    public function calculate(int $retry): int
    {
        return $this->cap($this->base);
    }
}
