<?php

namespace Assada;

/**
 * Interface ConfigInterface
 *
 * @package Assada
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
interface ConfigInterface extends \ArrayAccess, \Iterator
{
    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @param null   $fallback
     *
     * @return mixed
     */
    public function get(string $key, $fallback = null);

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function set(string $key, $value);

    /**
     * @return array
     */
    public function all(): array;
}