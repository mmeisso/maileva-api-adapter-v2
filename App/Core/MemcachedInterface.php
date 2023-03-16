<?php

namespace MailevaApiAdapter\App\Core;

interface MemcachedInterface
{

    /**
     * @param string $host
     * @param int $port
     * @return MemcachedManager
     */
    public static function getInstance(string $host='localhost', int $port=11211): MemcachedInterface;

    /**
     * Delete a given memcache key
     *
     * @param string $key
     * @param int $time If given this will be the time during with any add or replace operations will be forbidden after the deletion of the key
     *                     (set will work)
     *
     * @return bool
     */
    public function delete(string $key, int $time = 0): bool;

    /**
     * Return a memcache value
     *
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed Return false if memcache is not available or $default if there is no value on memcache for that key
     */
    public function get(string $key, $default = null);

    /**
     * Get all keys sorted into memcached
     *
     * @return array
     */
    public function getAllKeys(): array;

    public function set($key, $value, $duration = 0);

}