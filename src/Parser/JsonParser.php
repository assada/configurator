<?php

namespace Assada\Parser;

use Assada\Exception\ParseErrorException;


/**
 * Class JsonParser
 *
 * @package Assada\Parser
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class JsonParser implements ParserInterface
{

    /**
     * @inheritdoc
     *
     * @throws \Exception
     */
    public function parse(string $file): array
    {
        $data = json_decode(file_get_contents($file), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $errorMessage = json_last_error_msg();
            throw new ParseErrorException($errorMessage);
        }

        return $data;
    }
}