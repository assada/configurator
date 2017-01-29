<?php

namespace Assada\Adapter;

use Assada\Adapter\Yaml\YamlExtensionAdapter;
use Assada\Adapter\Yaml\YamlSymfonyAdapter;
use Symfony\Component\Yaml\Yaml;


/**
 * Class YamlFactory
 *
 * @package Assada\Adapter
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class YamlFactory
{
    private $instance;

    public function __construct(Yaml $yaml)
    {
        if (extension_loaded('yaml')) {
            $this->instance = new YamlExtensionAdapter();
        } else {
            $this->instance = new YamlSymfonyAdapter($yaml);
        }
    }


    public function getInstance()
    {
        return $this->instance;
    }
}