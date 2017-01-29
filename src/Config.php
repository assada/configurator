<?php

namespace Assada;

use Assada\Dumper\DumperInterface;
use Assada\Dumper\IniDumper;
use Assada\Dumper\JsonDumper;
use Assada\Dumper\PhpDumper;
use Assada\Dumper\YamlDumper;
use Assada\Exception\FileNotFoundException;
use Assada\Exception\UnsupportedExtensionException;
use Assada\Parser\IniParser;
use Assada\Parser\JsonParser;
use Assada\Parser\ParserInterface;
use Assada\Parser\PhpParser;
use Assada\Parser\XmlParser;
use Assada\Parser\YamlParser;


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
        YamlParser::class => ['yml'],
        IniParser::class  => ['ini'],
        PhpParser::class  => ['php'],
        XmlParser::class  => ['xml']
    ];

    protected $fileDumpers = [
        JsonDumper::class => ['json'],
        YamlDumper::class => ['yml'],
        IniDumper::class  => ['ini'],
        PhpDumper::class  => ['php']
    ];

    /**
     * Config constructor.
     *
     * @param $files
     *
     * @throws \Assada\Exception\FileNotFoundException
     * @throws \Assada\Exception\UnsupportedExtensionException
     */
    public function __construct($files)
    {
        $this->add($files);
    }

    /**
     * @param $files
     *
     * @return \Assada\Config
     * @throws \Assada\Exception\UnsupportedExtensionException
     * @throws \Assada\Exception\FileNotFoundException
     */
    public function add($files): Config
    {
        foreach ($this->getConfigFiles($files) as $file) {
            $info      = pathinfo($file);
            $parts     = explode('.', $info['basename']);
            $extension = array_pop($parts);

            $parser = $this->getParser($extension);

            $data = array_replace_recursive($this->all(), (array)$parser->parse($file));

            $this->setData($data);
        }

        return $this;
    }

    /**
     * @param $files
     *
     * @return array
     * @throws \Assada\Exception\FileNotFoundException
     */
    private function getConfigFiles($files): array
    {
        if (is_array($files)) {
            $result = [];
            foreach ($files as $file) {
                $result = array_merge($result, $this->getConfigFiles($file));
            }

            return $result;
        }

        if (is_dir($files)) {
            return glob($files . '/*.*');
        }

        if (!file_exists($files)) {
            throw new FileNotFoundException(sprintf('Configuration file: %s not found', $files));
        }

        return [
            $files
        ];
    }

    /**
     * @param string $extension
     *
     * @return \Assada\Parser\ParserInterface
     * @throws \Assada\Exception\UnsupportedExtensionException
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
            throw new UnsupportedExtensionException(sprintf('%s not supported such us configuration file', $extension));
        }

        return $parser;
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
     * @param string $extension
     *
     * @return string
     * @throws \Assada\Exception\UnsupportedExtensionException
     */
    public function dump(string $extension): string
    {
        $dumper = $this->getDumper($extension);

        return $dumper->dump($this->all());
    }

    /**
     * @param string $extension
     *
     * @return \Assada\Dumper\DumperInterface
     * @throws \Assada\Exception\UnsupportedExtensionException
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
            throw new UnsupportedExtensionException(sprintf('%s not supported such us dump format', $extension));
        }

        return $dumper;
    }
}
