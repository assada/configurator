<?php

namespace Assada\Dumper;


/**
 * Class JsonDumper
 *
 * @package Assada\Dumper
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class JsonDumper implements DumperInterface
{

    public function dump(array $data): string
    {
        $result = '';

        $result .= json_encode($data);

        return $result;
    }
}