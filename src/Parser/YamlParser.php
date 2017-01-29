<?php

namespace Assada\Parser;

use Assada\Adapter\YamlAdapter;
use Assada\Exception\ParseErrorException;
use Symfony\Component\Yaml\Yaml;


/**
 * Class YamlParser
 *
 * @package Assada\Parser
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class YamlParser implements ParserInterface
{
    /** @var Yaml|YamlAdapter $yaml */
    private static $yaml;

    public function __construct()
    {
        if (extension_loaded('yaml')) {
            self::$yaml = new static(YamlAdapter::class);
        } else {
            self::$yaml = new static(Yaml::class);
        }
    }

    /**
     * @inheritdoc
     *
     * @throws \Assada\Exception\ParseErrorException
     */
    public function parse(string $file): array
    {
        $data = self::$yaml->parse(file_get_contents($file));
        if (!$data) {
            throw new ParseErrorException('Error parsing yaml file');
        }

        return $data;
    }
}