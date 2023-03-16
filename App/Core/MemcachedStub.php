<?php

namespace MailevaApiAdapter\App\Core;

class MemcachedStub implements MemcachedInterface
{
    private static MemcachedStub $instance;
    private array $data = [];

    /**
     * @param string $host
     * @param int $port
     * @return MemcachedStub
     */
    public static function getInstance(string $host = 'localhost', int $port = 11211): MemcachedStub
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $key
     * @param int $time
     * @return bool
     */
    public function delete(string $key, int $time = 0): bool
    {
        unset($this->data[$key]);
        return true;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function getAllKeys(): array
    {
        return array_keys($this->data);
    }

    public function set($key, $value, $duration = 0)
    {
        $this->data[$key]=$value;
    }
}