<?php

namespace Assada;

use Assada\Dumper\DumperInterface;
use Assada\Dumper\JsonDumper;
use Assada\Parser\JsonParser;
use Assada\Parser\ParserInterface;


/**
 * Class Config
 *
 * @package Assada
 *
 * @author  Aleksey Ilyenko <assada.ua@gmail.com>
 */
class Config extends AbstractConfig
{
    protected $fileParsers = [
        JsonParser::class => ['json'],
    ];

    protected $fileDumpers = [
        JsonDumper::class => ['json'],
    ];

    /**
     * Config constructor.
     *
     * @param string|array $files
     *
     * @throws \Exception
     */
    public function __construct($files)
    {
        $this->add($files);
    }

    /**
     * @param array $dumpers
     *
     * @return \Assada\Config
     */
    public function addDumpers(array $dumpers): Config
    {
        $this->fileDumpers = array_merge($this->fileDumpers, $dumpers);

        return $this;
    }

    /**
     * @param array $parsers
     *
     * @return \Assada\Config
     */
    public function addParsers(array $parsers): Config
    {
        $this->fileParsers = array_merge($this->fileParsers, $parsers);

        return $this;
    }

    /**
     * @param string|array $files
     *
     * @return \Assada\Config
     * @throws \Exception
     */
    public function add($files): Config
    {
        foreach ($this->getConfigFiles($files) as $file) {
            $info      = pathinfo($file);
            $parts     = explode('.', $info['basename']);
            $extension = array_pop($parts);

            $parser = $this->getParser($extension);

            $this->data = array_replace_recursive($this->data, (array)$parser->parse($file));
        }

        return $this;
    }

    /**
     * @param string $extension
     *
     * @return string
     * @throws \Exception
     */
    public function dump(string $extension): string
    {
        $dumper = $this->getDumper($extension);

        return $dumper->dump($this->data);
    }

    /**
     * @param string $extension
     *
     * @return \Assada\Parser\ParserInterface
     * @throws \Exception
     */
    private function getParser(string $extension): ParserInterface
    {
        $parser = null;
        foreach ($this->fileParsers as $fileParser => $extensions) {
            if (in_array($extension, $extensions, false)) {
                $parser = new $fileParser();
            }
        }
        if (null === $parser) {
            throw new \Exception(sprintf('%s not supported such us configuration file', $extension));
        }

        return $parser;
    }

    /**
     * @param string $extension
     *
     * @return \Assada\Dumper\DumperInterface
     * @throws \Exception
     */
    private function getDumper(string $extension): DumperInterface
    {
        $dumper = null;
        foreach ($this->fileDumpers as $fileDumper => $extensions) {
            if (in_array($extension, $extensions, false)) {
                $dumper = new $fileDumper();
            }
        }
        if (null === $dumper) {
            throw new \Exception(sprintf('%s not supported such us configuration file', $extension));
        }

        return $dumper;
    }

    /**
     * @param array|string $files
     *
     * @return array
     * @throws \Exception
     */
    private function getConfigFiles($files): array
    {
        if (is_array($files)) {
            $result = [];
            foreach ((array)$files as $file) {
                $result = array_merge($result, $this->getConfigFiles($file));
            }

            return $result;
        }

        if (is_dir($files)) {
            $paths = glob($files . '/*.*');
            if (empty($paths)) {
                throw new \Exception(sprintf('Configuration directory: %s is empty', $files));
            }

            return $paths;
        }
        // If `$path` is not a file, throw an exception
        if (!file_exists($files)) {
            throw new \Exception(sprintf('Configuration file: %s cannot be found', $files));
        }

        return [$files];
    }
}
