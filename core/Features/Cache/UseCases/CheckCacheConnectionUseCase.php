<?php

namespace Core\Features\Cache\UseCases;

use Core\Features\Cache\Facades\CustomCache;
use Core\Models\Result;
use Exception;

class CheckCacheConnectionUseCase
{
    public function invoke()
    {
        $result = new Result();

        try {
            $result->success = CustomCache::isConnected();
            if ($result->success) {
                $result->message = sprintf('Cache connected');
            } else {
                $result->message = sprintf('Cache is not connected');
            }
        } catch (Exception $ex) {
            $result->message = sprintf('Cache is not connected: %s', $ex->getMessage());
        }

        return $result;
    }
}
