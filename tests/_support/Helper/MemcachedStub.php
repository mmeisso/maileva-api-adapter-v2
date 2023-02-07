<?php

namespace MailevaApiAdapter\tests\_support\Helper;

use MailevaApiAdapter\App\Core\MemcachedInterface;

class MemcachedStub implements MemcachedInterface
{


    private static MemcachedStub $instance;
    private array $data=[];
    public static function getInstance(string $host='localhost', int $port=11211): MemcachedStub
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($host, $port);
        }
        return self::$instance;
    }

    public function delete($key, $time = 0)
    {
        unset($this->data[$key]);
    }

    public function get($key, $default = null)
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