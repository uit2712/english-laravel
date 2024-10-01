<?php

namespace Core\Features\Cache\Traits;

trait CustomCacheTrait
{
    private function getKeyCacheFromList(array $segments)
    {
        return implode(':', $segments);
    }
}
