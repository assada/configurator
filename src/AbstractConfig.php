<?php

namespace Assada;


/**
 * Class AbstractConfig
 *
 * @package Assada
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class AbstractConfig implements ConfigInterface
{
    protected $data = [];

    /**
     * @inheritdoc
     */
    public function get(string $key, $fallback = null)
    {
        $keys = explode('.', $key);

        $value   = $fallback;
        $residue = $this->data;
        foreach ($keys as $k) {
            if (array_key_exists($k, $residue)) {
                $value = $residue = $residue[$k];
            } else {
                return $fallback;
            }
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function set(string $key, $value)
    {
        $map = explode('.', $key);

        $data = &$this->data;
        while ($k = array_shift($map)) {
            if (!array_key_exists($k, $data) && count($map)) {
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

        $residue = $this->data;
        foreach ($keys as $k) {
            if (array_key_exists($k, $residue)) {
                $residue = $residue[$k];
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