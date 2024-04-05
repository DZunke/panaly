<?php

declare(strict_types=1);

namespace Panaly\Configuration;

use Panaly\Configuration\Exception\InvalidConfigurationFile;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

use function is_file;
use function is_readable;

class ConfigurationFileLoader
{
    public function loadFromFile(string $filePath): ConfigurationFile
    {
        if (! is_file($filePath) || ! is_readable($filePath)) {
            throw InvalidConfigurationFile::fileNotFound($filePath);
        }

        try {
            $fileContent = Yaml::parseFile($filePath);
        } catch (ParseException $e) {
            throw InvalidConfigurationFile::fileContentNotValidYaml($filePath, $e);
        }

        return ConfigurationFile::fromArray($fileContent);
    }
}
