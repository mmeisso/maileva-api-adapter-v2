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
     * @param int    $time If given this will be the time during with any add or replace operations will be forbidden after the deletion of the key
     *                     (set will work)
     *
     * @return bool
     */
    public function delete($key, $time = 0);

    /**
     * Return a memcache value
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed Return false if memcache is not available or $default if there is no value on memcache for that key
     */
    public function get($key, $default = null);

    /**
     * Get all keys sorted into memcached
     *
     * @return array
     */
    public function getAllKeys();

    public function set($key, $value, $duration = 0);

}