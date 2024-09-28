<?php

namespace Framework\Features\Cache\Repositories;

use Core\Features\Cache\InterfaceAdapters\CustomCacheRepositoryInterface;
use Core\Helpers\ArrayHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CustomCacheRepository implements CustomCacheRepositoryInterface
{
    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::store('redis')->get($key, $default);
    }

    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        return Cache::store('redis')->set($key, $value, $ttl);
    }

    public function delete(string $key): bool
    {
        return Cache::store('redis')->delete($key);
    }

    public function clear(): bool
    {
        return Cache::store('redis')->clear();
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        return Cache::store('redis')->getMultiple($keys, $default);
    }

    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        return Cache::store('redis')->setMultiple($values, $ttl);
    }

    public function deleteMultiple(iterable $keys): bool
    {
        return Cache::store('redis')->deleteMultiple($keys);
    }

    public function has(string $key): bool
    {
        return Cache::store('redis')->has($key);
    }

    public function getMultipleKeepKeys($keys, $default = null)
    {
        if (ArrayHelper::isHasItems($keys) === false) {
            return array();
        }

        $values = Cache::store('redis')->getMultiple($keys, $default);

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
