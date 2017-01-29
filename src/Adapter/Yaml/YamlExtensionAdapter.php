<?php

namespace Assada\Adapter\Yaml;


/**
 * Class YamlExtensionAdapter
 *
 * @package Assada\Adapter\Yaml
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class YamlExtensionAdapter implements YamlInterface
{

    /**
     * @inheritdoc
     */
    public function parse(string $input)
    {
        return yaml_parse($input);
    }

    /**
     * @inheritdoc
     */
    public function dump(array $input): string
    {
        return yaml_emit($input);
    }
}