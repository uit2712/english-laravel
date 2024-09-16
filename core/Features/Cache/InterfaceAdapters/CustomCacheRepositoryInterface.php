<?php

namespace Core\Features\Cache\InterfaceAdapters;

use Psr\SimpleCache\CacheInterface;

interface CustomCacheRepositoryInterface extends CacheInterface
{
    /**
     * @param array $keys Keys.
     * @param mixed|null $default Default.
     */
    public function getMultipleKeepKeys($keys, $default = null);
}
