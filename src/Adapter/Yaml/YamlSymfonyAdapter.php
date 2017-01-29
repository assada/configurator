<?php

namespace Assada\Adapter\Yaml;

use Symfony\Component\Yaml\Yaml;


/**
 * Class YamlSymfonyAdapter
 *
 * @package Assada\Adapter\Yaml
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class YamlSymfonyAdapter implements YamlInterface
{
    /**
     * @var \Symfony\Component\Yaml\Yaml
     */
    private $yaml;

    public function __construct(Yaml $yaml)
    {
        $this->yaml = $yaml;
    }


    /**
     * @param string $input
     *
     * @return mixed
     * @throws \Symfony\Component\Yaml\Exception\ParseException
     */
    public function parse(string $input)
    {
        $yaml = $this->yaml;

        return $yaml::parse($input);
    }

    /**
     * @param array $input
     *
     * @return string
     */
    public function dump(array $input): string
    {
        $yaml = $this->yaml;

        return $yaml::dump($input);
    }
}