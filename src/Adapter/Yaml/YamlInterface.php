<?php
/**
 * Description YamlInterface.php
 *
 * @author Aleksey Ilyenko <assada.ua@gmail.com>
 *
 */

namespace Assada\Adapter\Yaml;


interface YamlInterface
{
    /**
     * @param string $input
     *
     * @return mixed
     */
    public function parse(string $input);

    /**
     * @param array $input
     *
     * @return string
     */
    public function dump(array $input): string;
}