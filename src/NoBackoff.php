<?php

declare(strict_types=1);

namespace Ayelect\Backoff;

class NoBackoff extends AbstractBackoff
{
    public function calculate(int $retry): int
    {
        return 0;
    }
}
