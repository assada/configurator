<?php

namespace Assada\Parser;

use Assada\Exception\Exception;
use Assada\Exception\ParseErrorException;


/**
 * Class PhpParser
 *
 * @package Assada\Parser
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class PhpParser implements ParserInterface
{

    /**
     * @param string $file
     *
     * @return array $data
     * @throws \Assada\Exception\ParseErrorException
     * @throws \Assada\Exception\Exception
     */
    public function parse(string $file): array
    {
        try {
            $data = require $file;
        } catch (\Throwable $e) {
            throw new Exception('Php file throw exception', $e->getCode(), $e);
        }

        if (!is_array($data)) {
            throw new ParseErrorException('PHP file does not return an array', 0, 1, $file, 0);
        }

        return $data;
    }
}