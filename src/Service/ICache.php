<?php

namespace App\Service;

interface ICache
{
    /**
     * Gets the value from the cache according to the given key.
     *
     * @param string $key
     * @return mixed|null Returns value or null if key doesn't exist.
     */
    public function get(string $key): mixed;

    /**
     * Sets value to cache with given key.
     *
     * @param string $key
     * @param mixed $value
     * @param int $ttl Lifetime (Time To Live) in seconds.
     * @return void
     */
    public function set(string $key, mixed $value, int $ttl): void;

    /**
     * Removes the value from cache
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;
}