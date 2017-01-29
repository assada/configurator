<?php

namespace Assada\Parser;

use Assada\Adapter\Yaml\YamlInterface;
use Assada\Adapter\YamlFactory;
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
    /** @var YamlInterface $yaml */
    private $yaml;

    public function __construct()
    {
        $yaml       = new Yaml();
        $this->yaml = (new YamlFactory($yaml))->getInstance();
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