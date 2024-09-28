<?php

namespace Core\Features\Cache\UseCases;

use Core\Features\Cache\Facades\CustomCache;
use Core\Models\Result;

class FlushAllCacheUseCase
{
    public function invoke()
    {
        $result = new Result();

        $result->success = CustomCache::clear();
        if ($result->success) {
            $result->message = sprintf('Flush all cache success');
        } else {
            $result->message = sprintf('Flush all cache failed');
        }

        return $result;
    }
}
