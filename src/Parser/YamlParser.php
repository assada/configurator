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
    private $yaml;

    public function __construct()
    {
        if (extension_loaded('yaml')) {
            $this->yaml = new static(YamlAdapter::class);
        } else {
            $this->yaml = new static(Yaml::class);
        }
    }

    /**
     * @inheritdoc
     *
     * @throws \Assada\Exception\ParseErrorException
     */
    public function parse(string $file): array
    {
        $data = $this->yaml->parse(file_get_contents($file));
        if (!$data) {
            throw new ParseErrorException('Error parsing yaml file');
        }

        return $data;
    }
}