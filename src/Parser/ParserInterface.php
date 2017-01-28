<?php

namespace Assada\Parser;

/**
 * Interface ParserInterface
 *
 * @package Assada\Parser
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
interface ParserInterface
{
    /**
     * @param string $file
     *
     * @return array $data
     */
    public function parse(string $file): array;
}