<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 25/01/2018
 * Time: 09:31
 */

namespace MailevaApiAdapter\App\Core;


class MemcachedManager
{

    private static $instance = null;
    /**
     * @var \Memcached
     * @throws \MemcachedException
     */
    private $memcached;

    private function __construct()
    {
        try {
            $this->memcached = new \Memcached();
            $this->memcached->addServer('localhost', 11211);
        } catch (\MemcachedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \MemcachedException('ERROR_UNABLE_TO_CONNECT');
        }
    }

    public static function getInstance(): MemcachedManager
    {
        if (is_null(self::$instance)) {
            self::$instance = new MemcachedManager();
        }
        return self::$instance;
    }

    /**
     * Delete a given memcache key
     *
     * @param string $key
     * @param int $time If given this will be the time during with any add or replace operations will be forbidden after the deletion of the key
     *                     (set will work)
     *
     * @return bool
     */
    public function delete($key, $time = 0)
    {
        return $this->memcached->delete($key, $time);
    }

    /**
     * Return a memcache value
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed Return false if memcache is not available or $default if there is no value on memcache for that key
     */
    public function get($key, $default = null)
    {

        $mmcValue = $this->memcached->get($key);

        # No value on memcache for that key, so return the default value if given
        if ($mmcValue === false && is_null($default) === false) {
            # Result code said that there is really a key that equals false, so returns false properly
            if ($this->memcached->getResultCode() === \Memcached::RES_SUCCESS) {
                return false;
            }

            # They key does not exists, returns the default given value if set
            if ($this->memcached->getResultCode() === \Memcached::RES_NOTFOUND && $default != null) {
                return $default;
            }
        }

        return $mmcValue;
    }

    /**
     * Get all keys sorted into memcached
     *
     * @return array
     */
    public function getAllKeys()
    {
        return $this->memcached->getAllKeys();
    }

    /**
     * Store a value into memcached in a specific key
     *
     * @param string $key
     * @param mixed $value
     * @param int $duration cache duration in seconds (0 = always)
     *
     * @return bool
     * @throws \MemcachedException
     */
    public function set($key, $value, $duration = 0)
    {
        $result = $this->memcached->set($key, $value, ($duration > 0) ? $duration : 0);

        if ($result === false) {
            throw new \MemcachedException('ERROR_CANNOT_STORE_KEY', $key);
        }

        return true;
    }

    private function __clone()
    {

    }


}