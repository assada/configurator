<?php

namespace Assada\Adapter;


/**
 * Class YamlAdapter
 *
 * @package Assada\Adapter
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class YamlAdapter
{
    /**
     * @param string $input
     *
     * @return array|bool
     */
    public static function parse(string $input)
    {
        return yaml_parse($input);
    }

    /**
     * @param array $input
     *
     * @return string
     */
    public static function dump(array $input): string
    {
        return yaml_emit($input);
    }
}