<?php

namespace Assada\Parser;

use Assada\Exception\ParseErrorException;


/**
 * Class IniParser
 *
 * @package Assada\Parser
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class IniParser implements ParserInterface
{

    /**
     * @inheritdoc
     *
     * @throws \Assada\Exception\ParseErrorException
     */
    public function parse(string $file): array
    {
        $data = [];
        $temp = @parse_ini_file($file, true);
        if (!$temp) {
            $error = error_get_last();
            error_clear_last();
            throw new ParseErrorException($error);
        }

        if (!is_array($temp)) {
            throw new ParseErrorException('Error parse ini file', 0, 1, $file);
        }

        foreach ($temp as $key => $value) {
            $this->assignArrayByPath($data, $key, $value);
        }

        return $data;
    }

    public function assignArrayByPath(&$arr, $path, $value)
    {
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            $arr = &$arr[$key];
        }

        $arr = $value;
    }
}