<?php

namespace Assada;

use ArrayAccess;
use Iterator;


/**
 * Class AbstractConfig
 *
 * @package Assada
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class AbstractConfig implements ArrayAccess, Iterator, ConfigInterface
{
    protected $data = [];

    protected $cache = [];

    /**
     * @inheritdoc
     */
    public function get(string $key, $fallback = null)
    {
        $keys = explode('.', $key);

        foreach ($keys as $k) {
            if (array_key_exists($k, $this->data)) {
                return $this->data[$k];
            } else {
                return false;
            }
        }

        return $fallback;
    }

    /**
     * @inheritdoc
     */
    public function set(string $key, $value)
    {
        $map = explode('.', $key);

        $data = &$this->data;
        while ($k = array_shift($map)) {
            if (!isset($data[$k]) && count($map)) {
                $data[$k] = [];
            }
            $data = &$data[$k];
            unset($map[$k]);
        }

        $data = $value;
    }

    /**
     * @inheritdoc
     */
    public function has(string $key): bool
    {
        $keys = explode('.', $key);

        foreach ($keys as $k) {
            if (array_key_exists($k, $this->data)) {
                continue;
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        return next($this->data);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return key($this->data) !== null;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        return reset($this->data);
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        $this->set($offset, null);
    }
}