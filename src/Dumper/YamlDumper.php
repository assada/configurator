<?php

namespace Assada\Dumper;

use Assada\Adapter\Yaml\YamlInterface;
use Assada\Adapter\YamlFactory;
use Symfony\Component\Yaml\Yaml;


/**
 * Class YamlDumper
 *
 * @package Assada\Dumper
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class YamlDumper implements DumperInterface
{
    /** @var YamlInterface */
    private $yaml;

    /**
     * YamlDumper constructor.
     */
    public function __construct()
    {
        $yaml       = new Yaml();
        $this->yaml = (new YamlFactory($yaml))->getInstance();
    }

    /**
     * @inheritdoc
     */
    public function dump(array $data): string
    {
        return $this->yaml->dump($data);
    }
}