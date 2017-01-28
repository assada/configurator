<?php

namespace Assada;

use Assada\Parser\JsonParser;


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

    /**
     * Config constructor.
     *
     * @param string|array $files
     */
    public function __construct($files)
    {
        $this->add($files);
    }

    /**
     * @param string|array $files
     *
     * @return \Assada\Config
     */
    public function add($files): Config
    {
        $files = $this->getConfigFiles($files);

        foreach ($files as $file) {
            $info      = pathinfo($file);
            $parts     = explode('.', $info['basename']);
            $extension = array_pop($parts);
            if ($extension === 'dist') {
                $extension = array_pop($parts);
            }
            $parser = $this->getParser($extension);

            $this->data = array_replace_recursive($this->data, (array)$parser->parse($file));
        }

        return $this;
    }

    private function getParser($extension)
    {
        foreach ($this->fileParsers as $fileParser => $extensions) {
            if (in_array($extension, $extensions, false)) {
                return new $fileParser();
            }
        }

        throw new \Exception(sprintf('%s not supported such us configuration file', $extension));
    }

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
            $paths = glob($files . '/*.*');
            if (empty($paths)) {
                throw new \Exception("Configuration directory: [$files] is empty");
            }

            return $paths;
        }
        // If `$path` is not a file, throw an exception
        if (!file_exists($files)) {
            throw new \Exception("Configuration file: [$files] cannot be found");
        }

        return [$files];
    }
}