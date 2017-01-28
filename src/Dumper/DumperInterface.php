<?php

namespace Assada\Dumper;

/**
 * Interface DumperInterface
 *
 * @package Assada\Dumper
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
interface DumperInterface
{
    public function dump(array $data): string;
}