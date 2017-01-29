<?php

namespace Assada\Dumper;

use Assada\Adapter\YamlAdapter;
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
    /** @var Yaml|YamlAdapter */
    private $yaml;

    /**
     * YamlDumper constructor.
     */
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
     */
    public function dump(array $data): string
    {
        return $this->yaml->dump($data);
    }
}