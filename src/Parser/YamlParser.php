<?php

namespace Assada\Parser;

use Assada\Exception\ParseErrorException;


/**
 * Class YamlParser
 *
 * @package Assada\Parser
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class YamlParser implements ParserInterface
{

    /**
     * @inheritdoc
     *
     * @throws \Assada\Exception\ParseErrorException
     */
    public function parse(string $file): array
    {
        $data = yaml_parse_file($file);

        if (!$data) {
            throw new ParseErrorException('Error parsing yaml file');
        }

        return $data;
    }
}