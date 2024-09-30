<?php

namespace Framework\Features\Cache\Repositories;

use Core\Features\Cache\InterfaceAdapters\CustomCacheRepositoryInterface;
use Core\Helpers\ArrayHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CustomCacheRepository implements CustomCacheRepositoryInterface
{
    private $store = 'redis';

    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::store($this->store)->get($key, $default);
    }

    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        return Cache::store($this->store)->set($key, $value, $ttl);
    }

    public function delete(string $key): bool
    {
        return Cache::store($this->store)->delete($key);
    }

    public function clear(): bool
    {
        return Cache::store($this->store)->clear();
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        return Cache::store($this->store)->getMultiple($keys, $default);
    }

    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        return Cache::store($this->store)->setMultiple($values, $ttl);
    }

    public function deleteMultiple(iterable $keys): bool
    {
        return Cache::store($this->store)->deleteMultiple($keys);
    }

    public function has(string $key): bool
    {
        return Cache::store($this->store)->has($key);
    }

    public function getMultipleKeepKeys($keys, $default = null)
    {
        if (ArrayHelper::isHasItems($keys) === false) {
            return array();
        }

        $values = Cache::store($this->store)->getMultiple($keys, $default);

        $result = array();
        foreach ($values as $keyCache => $value) {
            if (isset($value) === false || false === $value) {
                $result[ $keyCache ] = $default;
            } else {
                $result[ $keyCache ] = $value;
            }
        }

        return $result;
    }

    public function isConnected(): bool
    {
        return Redis::client()->ping();
    }
}
