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
    private static $yaml;

    /**
     * YamlDumper constructor.
     */
    public function __construct()
    {
        if (extension_loaded('yaml')) {
            self::$yaml = new YamlAdapter();
        } else {
            self::$yaml = new Yaml();
        }
    }

    /**
     * @inheritdoc
     */
    public function dump(array $data): string
    {
        return self::$yaml->dump($data);
    }
}