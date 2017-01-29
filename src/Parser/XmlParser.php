<?php

namespace Assada\Parser;

use Assada\Exception\ParseErrorException;


/**
 * Class XmlParser
 *
 * @package Assada\Parser
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class XmlParser implements ParserInterface
{

    /**
     * @inheritdoc
     *
     * @throws \Assada\Exception\ParseErrorException
     */
    public function parse(string $file): array
    {
        libxml_use_internal_errors(true);
        $data = simplexml_load_file($file, null, LIBXML_NOERROR);
        if (!$data) {
            $errors = libxml_get_errors();
            $error  = array_pop($errors);
            throw new ParseErrorException($error->message, $error->code, 1, $error->file, $error->line);
        }

        return json_decode(json_encode($data), true);
    }
}