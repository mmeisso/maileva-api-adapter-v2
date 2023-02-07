<?php
/**
 * Created by PhpStorm.
 * User: Loïc
 * Date: 25/01/2018
 * Time: 09:31
 */

namespace MailevaApiAdapter\App\Core;

use Exception;
use Memcached;
use MemcachedException;

/**
 * Class MemcachedManager
 *
 * @package MailevaApiAdapter\App\Core
 */
class MemcachedManager implements MemcachedInterface
{

    private static ?MemcachedManager $instance = null;
    /**
     * @throws MemcachedException
     * @var Memcached
     */
    private Memcached $memcached;

    /**
     * MemcachedManager constructor.
     *
     * @param string $host
     * @param int    $port
     */
    private function __construct(string $host, int $port)
    {
        try {
            $this->memcached = new Memcached();
            $this->memcached->addServer($host, $port);
        } catch (MemcachedException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new MemcachedException('ERROR_UNABLE_TO_CONNECT');
        }
    }

    /**
     * @param string $host
     * @param int $port
     * @return MemcachedManager
     */
    public static function getInstance(string $host='localhost', int $port=11211): MemcachedManager
    {
        if (is_null(self::$instance)) {
            self::$instance = new MemcachedManager($host, $port);
        }
        return self::$instance;
    }

    /**
     * Delete a given memcache key
     *
     * @param string $key
     * @param int    $time If given this will be the time during with any add or replace operations will be forbidden after the deletion of the key
     *                     (set will work)
     *
     * @return bool
     */
    public function delete($key, $time = 0): bool
    {
        return $this->memcached->delete($key, $time);
    }

    /**
     * Return a memcache value
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed Return false if memcache is not available or $default if there is no value on memcache for that key
     */
    public function get($key, $default = null)
    {
        $mmcValue = $this->memcached->get($key);

        # No value on memcache for that key, so return the default value if given
        if ($mmcValue === false && is_null($default) === false) {
            # Result code said that there is really a key that equals false, so returns false properly
            if ($this->memcached->getResultCode() === Memcached::RES_SUCCESS) {
                return false;
            }

            # They key does not exists, returns the default given value if set
            if ($this->memcached->getResultCode() === Memcached::RES_NOTFOUND && $default != null) {
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
    public function getAllKeys(): array
    {
        return $this->memcached->getAllKeys();
    }

    /**
     * Store a value into memcached in a specific key
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $duration cache duration in seconds (0 = always)
     *
     * @return bool
     * @throws MemcachedException
     */
    public function set($key, $value, $duration = 0): bool
    {
        $result = $this->memcached->set($key, $value, ($duration > 0) ? $duration : 0);

        if ($result === false) {
            throw new MemcachedException($this->memcached->getResultMessage());
        }

        return true;
    }

    private function __clone()
    {
    }
}
