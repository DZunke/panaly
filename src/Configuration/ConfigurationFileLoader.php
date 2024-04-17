<?php

declare(strict_types=1);

namespace Panaly\Configuration;

use Panaly\Configuration\Exception\InvalidConfigurationFile;
use Panaly\Provider\FileProvider;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ConfigurationFileLoader
{
    public function loadFromFile(FileProvider $fileProvider, string $filePath): ConfigurationFile
    {
        try {
            $fileContent = Yaml::parse($fileProvider->read($filePath));
        } catch (ParseException $e) {
            throw InvalidConfigurationFile::fileContentNotValidYaml($filePath, $e);
        }

        return ConfigurationFile::fromArray($fileContent);
    }
}
